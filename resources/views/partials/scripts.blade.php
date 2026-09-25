<!-- Centralized backend scripts include -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Small helper: format stock badge color based on available number
function colorizeStockBadges(){
  document.querySelectorAll('.stock-badge').forEach(b => {
    const text = b.textContent || '';
    const m = text.match(/(\d+)/);
    const n = m ? Number(m[1]) : null;
    b.classList.remove('badge-stock-ok','badge-stock-low','badge-stock-out');
    if(n === null) return b.classList.add('badge-stock-out');
    if(n <= 0) b.classList.add('badge-stock-out');
    else if(n <= 3) b.classList.add('badge-stock-low');
    else b.classList.add('badge-stock-ok');
  });
}
document.addEventListener('DOMContentLoaded', colorizeStockBadges);

function bukaModalTolak(actionUrl, jenisKonten) {
    const form = document.getElementById('formModalTolak');
    const input = document.getElementById('inputCatatanPenolakan');
    const err = document.getElementById('errorCatatanPenolakan');
    if (!form || !input) return;
    
    form.action = actionUrl;
    input.value = '';
    if (err) err.classList.add('d-none');
    
    const modalAsetEl = document.getElementById('modalPreviewAset');
    if (modalAsetEl) {
        const modalAset = bootstrap.Modal.getInstance(modalAsetEl);
        if (modalAset) modalAset.hide();
    }
    const modalAlbumEl = document.getElementById('modalPreviewAlbum');
    if (modalAlbumEl) {
        const modalAlbum = bootstrap.Modal.getInstance(modalAlbumEl);
        if (modalAlbum) modalAlbum.hide();
    }

    const modalTolak = new bootstrap.Modal(document.getElementById('modalTolakPersetujuan'));
    modalTolak.show();
}

function validasiAlasanPenolakan(form) {
    const input = document.getElementById('inputCatatanPenolakan');
    const err = document.getElementById('errorCatatanPenolakan');
    if (!input || !input.value.trim()) {
        if (err) err.classList.remove('d-none');
        if (input) input.focus();
        return false;
    }
    return true;
}
</script>