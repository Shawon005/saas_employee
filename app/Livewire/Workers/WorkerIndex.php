<?php

namespace App\Livewire\Workers;

use App\Models\Department;
use App\Models\SalarySetting;
use App\Models\Shift;
use App\Models\Worker;
use App\Services\QrService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class WorkerIndex extends Component
{
    use WithFileUploads;
    use WithPagination;

    #[Url]
    public string $search = '';
    public string $department = '';
    public string $grade = '';
    public string $status = '';
    public bool $showModal = false;
    public bool $isEditing = false;
    public array $selected = [];
    public ?int $editingWorkerId = null;
    public string $name = '';
    public string $workerGrade = 'Grade-1';
    public string $departmentId = '';
    public string $shiftId = '';
    public string $basicSalary = '';
    public string $houseRent = '';
    public string $medicalAllowance = '';
    public string $joinDate = '';
    public $photo;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'workerGrade' => ['required', 'in:Grade-1,Grade-2,Grade-3'],
            'departmentId' => ['required', 'exists:departments,id'],
            'shiftId' => ['required', 'exists:shifts,id'],
            'basicSalary' => ['required', 'numeric'],
            'houseRent' => ['nullable', 'numeric'],
            'medicalAllowance' => ['nullable', 'numeric'],
            'joinDate' => ['required', 'date'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function createWorker(): void
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(int $workerId): void
    {
        $worker = Worker::where('company_id', auth()->user()->company_id)->findOrFail($workerId);

        $this->resetValidation();
        $this->reset('photo');

        $this->showModal = true;
        $this->isEditing = true;
        $this->editingWorkerId = $worker->id;
        $this->name = $worker->name;
        $this->workerGrade = $worker->grade;
        $this->departmentId = (string) $worker->department_id;
        $this->shiftId = (string) $worker->shift_id;
        $this->basicSalary = (string) $worker->basic_salary;
        $this->houseRent = (string) $worker->house_rent;
        $this->medicalAllowance = (string) $worker->medical_allowance;
        $this->joinDate = optional($worker->join_date)->format('Y-m-d') ?? '';
    }

    public function closeModal(): void
    {
        $this->resetForm();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedDepartment(): void
    {
        $this->resetPage();
    }

    public function updatedGrade(): void
    {
        $this->resetPage();
    }

    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    public function save(QrService $qrService): void
    {
        $this->validate();

        $companyId = auth()->user()->company_id;
        $worker = $this->editingWorkerId
            ? Worker::where('company_id', $companyId)->findOrFail($this->editingWorkerId)
            : new Worker();

        $path = $worker->photo;

        if ($this->photo) {
            $path = $this->photo->store('workers', 'public');

            if ($this->isEditing && $worker->photo) {
                Storage::disk('public')->delete($worker->photo);
            }
        }

        $worker->fill([
            'company_id' => $worker->company_id ?: $companyId,
            'emp_id' => $worker->emp_id ?: $qrService->generateEmpId(),
            'name' => $this->name,
            'grade' => $this->workerGrade,
            'department_id' => $this->departmentId,
            'shift_id' => $this->shiftId,
            'basic_salary' => $this->basicSalary,
            'house_rent' => $this->houseRent ?: 0,
            'medical_allowance' => $this->medicalAllowance ?: 0,
            'attendance_bonus_eligible' => true,
            'qr_code_token' => $worker->qr_code_token ?: (string) Str::uuid(),
            'photo' => $path,
            'join_date' => $this->joinDate,
            'status' => $worker->status ?: 'active',
        ]);

        $worker->save();
        $qrService->ensureWorkerIdentity($worker);
        $this->resetForm();
    }

    public function deactivate(int $workerId): void
    {
        Worker::whereKey($workerId)->update(['status' => 'inactive']);
    }

    protected function resetForm(): void
    {
        $this->resetValidation();
        $this->reset([
            'showModal',
            'isEditing',
            'editingWorkerId',
            'name',
            'departmentId',
            'shiftId',
            'basicSalary',
            'houseRent',
            'medicalAllowance',
            'joinDate',
            'photo',
        ]);
        $this->workerGrade = 'Grade-1';
    }

    public function render()
    {
        $companyId = auth()->user()->company_id;
        $settings = SalarySetting::where('company_id', $companyId)->first();

        $workers = Worker::with(['department', 'shift'])
            ->where('company_id', $companyId)
            ->when($this->search, fn ($query) => $query->where(fn ($q) => $q
                ->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('emp_id', 'like', '%' . $this->search . '%')))
            ->when($this->department, fn ($query) => $query->where('department_id', $this->department))
            ->when($this->grade, fn ($query) => $query->where('grade', $this->grade))
            ->when($this->status, fn ($query) => $query->where('status', $this->status))
            ->latest()
            ->paginate(10);

        return view('livewire.workers.worker-index', [
            'workers' => $workers,
            'departments' => Department::where('company_id', $companyId)->get(),
            'shifts' => Shift::where('company_id', $companyId)->get(),
            'houseRentPercent' => $settings?->house_rent_percent ?? 50,
            'storageUrl' => fn (?string $path) => $path ? Storage::url($path) : null,
        ]);
    }
}
