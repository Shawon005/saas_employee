@php
    $photoPath = $worker->photo ? storage_path('app/public/' . $worker->photo) : null;
    $photoMime = $photoPath && file_exists($photoPath) ? mime_content_type($photoPath) : null;
    $photoDataUri = $photoMime ? 'data:' . $photoMime . ';base64,' . base64_encode(file_get_contents($photoPath)) : null;
    $joinDate = $worker->join_date ? $worker->join_date->format('d/m/Y') : 'N/A';
    $companyPhone = $worker->company->phone ?: 'Phone not available';
    $companyAddress = $worker->company->address ?: 'Address not available';
    $nameLength = mb_strlen($worker->name);
    $nameClass = $nameLength > 22 ? 'name name-small' : 'name';
@endphp

<div class="card front">
    <div class="shape shape-top"></div>
    <div class="shape shape-bottom"></div>
    <div class="molecule molecule-left">
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="molecule molecule-right">
        <span></span><span></span><span></span><span></span>
    </div>

    <div class="front-header">
        <div class="{{ $nameClass }}">{{ strtoupper($worker->company->name) }}</div>
        <div class="role">{{ strtoupper($worker->department->name) }}</div>
    </div>

    <div class="photo-ring">
        <div class="photo-shell">
            @if ($photoDataUri)
                <img src="{{ $photoDataUri }}" alt="{{ $worker->name }}">
            @else
                <div class="photo-placeholder">NO PHOTO</div>
            @endif
        </div>
    </div>

    <div class="front-footer">
        <div class="company-name">{{ strtoupper($worker->name) }}</div>
        <div class="meta-line"><strong>ID NO:</strong> {{ $worker->emp_id }}</div>
        <div class="meta-line"><strong>Join Date:</strong> {{ $joinDate }}</div>
        <div class="meta-line"><strong>Grade:</strong> {{ $worker->grade }}</div>
    </div>
</div>

<div class="card back">
    <div class="shape shape-top"></div>
    <div class="shape shape-bottom"></div>
    <div class="molecule molecule-back-top">
        <span></span><span></span><span></span><span></span>
    </div>
    <div class="molecule molecule-back-bottom">
        <span></span><span></span><span></span><span></span>
    </div>

    <div class="terms-title">SCAN FOR ATTENDANCE</div>
    <!-- <div class="terms-copy">
        This card is issued for employee identification and attendance scanning. Please keep it safe and bring it during duty hours.
    </div> -->

    <div class="qr-frame" style="width: 28mm; height: 28mm; margin: 4mm auto 0; padding: 2.2mm; background: #ffffff; box-sizing: border-box;">
        <img src="{{ $qrImage }}" alt="QR code for {{ $worker->name }}">
    </div>

    <div class="back-footer">
        <div>{{ $companyPhone }}</div>
        <div>{{ $companyAddress }}</div>
    </div>
</div>
