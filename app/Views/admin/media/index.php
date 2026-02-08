<?php
/**
 * Admin Media Library - Tailwind CSS Redesign
 */
$pageTitle = $t('media');
ob_start();
?>

<div class="bg-white rounded-2xl border border-stone-100 shadow-sm overflow-hidden">
    <div class="flex items-center justify-between px-5 py-4 border-b border-stone-100">
        <h3 class="font-semibold text-stone-800"><?= $t('media_library') ?></h3>
        <button onclick="document.getElementById('mediaUpload').click()" class="inline-flex items-center gap-1.5 px-4 py-2 bg-brand-gold text-white text-sm font-medium rounded-lg hover:bg-brand-gold-dark transition shadow-sm">
            <i class="fas fa-upload text-xs"></i> <?= $t('upload') ?>
        </button>
        <input type="file" id="mediaUpload" onchange="uploadMedia(this)" multiple accept="image/*" class="hidden">
    </div>

    <!-- Drop Zone -->
    <div id="dropZone" onclick="document.getElementById('mediaUpload').click()"
         class="mx-5 mt-5 p-8 border-2 border-dashed border-stone-200 rounded-2xl text-center cursor-pointer transition-all hover:border-brand-gold hover:bg-brand-gold/5">
        <i class="fas fa-cloud-upload-alt text-3xl text-stone-300 mb-2"></i>
        <p class="text-sm text-stone-500"><?= $t('drag_drop') ?? 'Drag & drop files here or click to upload' ?></p>
        <p class="text-xs text-stone-400 mt-1">Max: 5MB per file. Formats: JPG, PNG, GIF, WebP</p>
    </div>
    <div id="uploadProgress" class="hidden px-5 mt-3">
        <div class="h-1.5 bg-stone-100 rounded-full overflow-hidden">
            <div id="progressBar" class="h-full bg-gradient-to-r from-brand-gold to-brand-gold-light rounded-full transition-all duration-300" style="width:0%"></div>
        </div>
    </div>

    <!-- Media Grid -->
    <div class="p-5">
        <div id="mediaGrid" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-4">
            <?php if (!empty($media)): ?>
                <?php foreach ($media as $item): ?>
                <div class="media-item group relative border border-stone-100 rounded-xl overflow-hidden hover:shadow-md transition-shadow">
                    <img src="<?= upload_url($item->file_path) ?>" alt="<?= $item->alt_text ?? '' ?>" class="w-full h-32 object-cover">
                    <div class="p-2.5">
                        <p class="text-xs font-medium text-stone-700 truncate"><?= $item->original_name ?? basename($item->file_path) ?></p>
                        <p class="text-[0.65rem] text-stone-400"><?= round(($item->file_size ?? 0) / 1024) ?>KB</p>
                    </div>
                    <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition">
                        <button onclick="copyUrl('<?= upload_url($item->file_path) ?>')" class="w-7 h-7 flex items-center justify-center rounded-lg bg-black/60 text-white text-xs hover:bg-black/80 transition">
                            <i class="fas fa-link"></i>
                        </button>
                        <button onclick="deleteMedia(<?= $item->id ?>, this)" class="w-7 h-7 flex items-center justify-center rounded-lg bg-red-500/80 text-white text-xs hover:bg-red-600 transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-span-full text-center text-stone-400 py-12">
                <i class="fas fa-images text-3xl mb-2 block opacity-30"></i>
                <?= $t('no_media') ?? 'No media files yet' ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
const dropZone = document.getElementById('dropZone');
['dragover','dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.add('border-brand-gold', 'bg-brand-gold/5'); }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.classList.remove('border-brand-gold', 'bg-brand-gold/5'); }));
dropZone.addEventListener('drop', e => { if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files); });

function uploadMedia(input) { if (input.files.length) uploadFiles(input.files); }

async function uploadFiles(files) {
    const progress = document.getElementById('uploadProgress');
    const bar = document.getElementById('progressBar');
    progress.classList.remove('hidden');
    for (let i = 0; i < files.length; i++) {
        bar.style.width = ((i + 1) / files.length * 100) + '%';
        const fd = new FormData();
        fd.append('file', files[i]);
        try {
            const res = await fetch('<?= url('admin/media/upload') ?>', { method: 'POST', body: fd });
            const data = await res.json();
            if (data.success) location.reload();
            else alert(data.message || 'Upload failed');
        } catch(e) { alert('Upload error'); }
    }
    progress.classList.add('hidden');
}

async function deleteMedia(id, btn) {
    if (!confirm('<?= $t('confirm_delete') ?>')) return;
    try {
        const res = await fetch('<?= url('admin/media/delete/') ?>' + id, { method: 'POST' });
        const data = await res.json();
        if (data.success) btn.closest('.media-item').remove();
    } catch(e) { alert('Delete failed'); }
}

function copyUrl(url) {
    navigator.clipboard.writeText(url).then(() => {
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-stone-800 text-white text-sm px-4 py-2 rounded-xl shadow-lg z-50';
        toast.textContent = 'URL copied!';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    });
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
