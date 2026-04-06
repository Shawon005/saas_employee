<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 18px; }
        body { margin: 0; font-family: DejaVu Sans, sans-serif; color: #ffffff; }
        .sheet { width: 100%; text-align: center; }
        .card {
            position: relative;
            width: 85mm;
            height: 54mm;
            display: inline-block;
            vertical-align: top;
            margin: 8px 7px;
            padding: 12px;
            overflow: hidden;
            border-radius: 14px;
            background: #1798f2;
            box-sizing: border-box;
        }
        .front { background: #1ea3f1; }
        .back { background: #1c97ee; }
        .shape {
            position: absolute;
            background: #1a7ee6;
            opacity: 0.9;
            border-radius: 999px;
        }
        .shape-top { width: 62mm; height: 28mm; top: -9mm; right: -10mm; }
        .shape-bottom { width: 72mm; height: 34mm; bottom: -16mm; left: -12mm; }
        .molecule {
            position: absolute;
            width: 16mm;
            height: 16mm;
            opacity: 0.25;
        }
        .molecule span {
            position: absolute;
            width: 2.2mm;
            height: 2.2mm;
            border-radius: 50%;
            background: #7bf7d2;
        }
        .molecule span:nth-child(1) { top: 0; left: 6.8mm; }
        .molecule span:nth-child(2) { top: 5mm; left: 0; }
        .molecule span:nth-child(3) { top: 5mm; right: 0; }
        .molecule span:nth-child(4) { bottom: 0; left: 6.8mm; }
        .molecule-left { top: 18mm; left: 4mm; }
        .molecule-right { top: 16mm; right: 4mm; }
        .molecule-back-top { top: 4mm; left: 5mm; }
        .molecule-back-bottom { right: 4mm; bottom: 6mm; }
        .front-header,
        .front-footer,
        .terms-title,
        .terms-copy,
        .qr-frame,
        .back-footer,
        .photo-ring { position: relative; z-index: 2; }
        .name {
            width: 100%;
            max-height: 10mm;
            overflow: hidden;
            font-size: 5mm;
            line-height: 1.02;
            font-weight: bold;
            color: #d7ff4e;
            letter-spacing: 0.2px;
            word-break: break-word;
        }
        .name-small {
            font-size: 5.7mm;
            line-height: 1.04;
        }
        .role {
            margin-top: 1.2mm;
            font-size: 2.9mm;
            letter-spacing: 0.8px;
            color: #d8efff;
        }
        .photo-ring {
            width: 14mm;
            height: 14mm;
            margin: 1mm auto 0;
            border-radius: 50%;
            padding: 1.7mm;
            background: #1658db;
        }
        .photo-shell {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: #d9d9d9;
            border: 0.5mm solid #54b6ff;
            box-sizing: border-box;
        }
        .photo-shell img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo-placeholder {
            width: 100%;
            height: 100%;
            text-align: center;
            color: #4b5563;
            font-size: 3.4mm;
            line-height: 30mm;
            font-weight: bold;
        }
        .front-footer {
            position: absolute;
            left: 12px;
            right: 12px;
            bottom: 10px;
            text-align: center;
        }
        .company-name {
            font-size: 4.2mm;
            font-weight: bold;
            color:rgb(255, 255, 255);
            margin-bottom: 1mm;
        }
        .meta-line {
            font-size: 3.4mm;
            line-height: 1.15;
            color: #eef9ff;
        }
        .meta-line strong { color: #ffffff; }
        .terms-title {
            margin-top: 0.5mm;
            text-align: center;
            font-size: 4.7mm;
            line-height: 1.1;
            font-weight: bold;
            color: #ffe548;
        }
        .terms-copy {
            width: 55mm;
            margin: 2.5mm auto 0;
            text-align: center;
            font-size: 2.75mm;
            line-height: 1.55;
            color: #edf8ff;
        }
        .qr-frame {
            width: 32mm;
            height: 32mm;
            margin: 4mm auto 0;
            padding: 2.2mm;
            background: #ffffff;
            box-sizing: border-box;
        }
        .qr-frame img { width: 100%; height: 100%; display: block; }
        .back-footer {
            position: absolute;
            left: 10px;
            right: 10px;
            bottom: 8px;
            text-align: center;
            font-size: 2.8mm;
            line-height: 1.45;
            color: #ecf9ff;
        }
    </style>
</head>
<body>
    <div class="sheet">
        @include('pdf.partials.id-card-pair', ['worker' => $worker, 'qrImage' => $qrImage])
    </div>
</body>
</html>
