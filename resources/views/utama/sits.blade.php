<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Server Info</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
        }
        .card {
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        .url-box {
            background-color: #f1f3f5;
            border-radius: 10px;
            padding: 10px 15px;
            font-size: 16px;
            word-break: break-all;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button {
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="card text-center">
    <h3 class="mb-3">🌐 Akses URL Jaringan Lokal</h3>
    <p class="mb-4 text-muted">Gunakan URL berikut untuk membuka aplikasi ini dari perangkat lain di jaringan yang sama.</p>

    <div class="url-box mb-3">
        <span id="localUrl">{{ request()->getSchemeAndHttpHost() }}</span>
        <button class="btn btn-primary btn-sm" onclick="copyUrl()">Salin</button>
    </div>

    <small class="text-success" id="copiedText" style="display:none;">✅ URL berhasil disalin!</small>
</div>

<script>
function copyUrl() {
    const urlElement = document.getElementById('localUrl');
    const urlText = urlElement.textContent.trim();

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(urlText).then(() => {
            showCopied();
        }).catch(() => {
            fallbackCopy(urlText);
        });
    } else {
        fallbackCopy(urlText);
    }
}

function fallbackCopy(text) {
    const tempInput = document.createElement('textarea');
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand('copy');
    document.body.removeChild(tempInput);
    showCopied();
}

function showCopied() {
    const copiedText = document.getElementById('copiedText');
    copiedText.style.display = 'inline';
    setTimeout(() => copiedText.style.display = 'none', 2000);
}
</script>
</body>
</html>
