<?php
/**
 * Admin Media Library
 */
$pageTitle = $t('media');
ob_start();
?>

<div class="admin-card">
    <div class="admin-card__header">
        <h3><?= $t('media_library') ?></h3>
        <div>
            <button class="btn btn-gold btn-sm" onclick="document.getElementById('mediaUpload').click()">
                <i class="fas fa-upload"></i> <?= $t('upload') ?>
            </button>
            <input type="file" id="mediaUpload" onchange="uploadMedia(this)" multiple accept="image/*" style="display:none;">
        </div>
    </div>
    
    <!-- Upload Zone -->
    <div id="dropZone" style="padding:2rem;border:2px dashed var(--border-color);margin:1rem 1.5rem;border-radius:var(--radius-lg);text-align:center;transition:all 0.3s ease;cursor:pointer;"
         onclick="document.getElementById('mediaUpload').click()">
        <i class="fas fa-cloud-upload-alt" style="font-size:2rem;color:var(--text-muted);margin-bottom:0.5rem;"></i>
        <p class="text-muted"><?= $t('drag_drop') ?? 'Drag & drop files here or click to upload' ?></p>
        <p class="text-xs text-muted">Max: 5MB per file. Formats: JPG, PNG, GIF, WebP</p>
    </div>
    <div id="uploadProgress" style="display:none;padding:0 1.5rem;">
        <div style="background:var(--bg-secondary);border-radius:var(--radius-full);overflow:hidden;height:6px;">
            <div id="progressBar" style="height:100%;background:var(--gold);transition:width 0.3s;width:0%;"></div>
        </div>
    </div>
    
    <!-- Media Grid -->
    <div class="admin-card__body">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:1rem;" id="mediaGrid">
            <?php if (!empty($media)): ?>
                <?php foreach ($media as $item): ?>
                <div class="media-item" style="position:relative;border:1px solid var(--border-color);border-radius:var(--radius-md);overflow:hidden;">
                    <img src="<?= upload_url($item->file_path) ?>" alt="<?= $item->alt_text ?? '' ?>" 
                         style="width:100%;height:140px;object-fit:cover;">
                    <div style="padding:0.5rem;">
                        <p class="text-xs" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= $item->original_name ?? basename($item->file_path) ?></p>
                        <p class="text-xs text-muted"><?= round(($item->file_size ?? 0) / 1024) ?>KB</p>
                    </div>
                    <div style="position:absolute;top:4px;right:4px;display:flex;gap:4px;">
                        <button onclick="copyUrl('<?= upload_url($item->file_path) ?>')" class="btn btn-sm" style="background:rgba(0,0,0,0.7);color:#fff;padding:4px 8px;">
                            <i class="fas fa-link"></i>
                        </button>
                        <button onclick="deleteMedia(<?= $item->id ?>, this)" class="btn btn-sm" style="background:rgba(231,76,60,0.9);color:#fff;padding:4px 8px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:2rem;" class="text-muted">
                <i class="fas fa-images" style="font-size:2rem;margin-bottom:0.5rem;display:block;"></i>
                <?= $t('no_media') ?? 'No media files yet' ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Drag & Drop
const dropZone = document.getElementById('dropZone');
['dragover','dragenter'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.style.borderColor = 'var(--gold)'; dropZone.style.background = 'var(--gold-light,#d4af3710)'; }));
['dragleave','drop'].forEach(e => dropZone.addEventListener(e, ev => { ev.preventDefault(); dropZone.style.borderColor = 'var(--border-color)'; dropZone.style.background = ''; }));
dropZone.addEventListener('drop', e => { if (e.dataTransfer.files.length) uploadFiles(e.dataTransfer.files); });

function uploadMedia(input) { if (input.files.length) uploadFiles(input.files); }

async function uploadFiles(files) {
    const progress = document.getElementById('uploadProgress');
    const bar = document.getElementById('progressBar');
    progress.style.display = 'block';
    
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
    progress.style.display = 'none';
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
    navigator.clipboard.writeText(url);
    alert('URL copied!');
}
</script>

<?php
$content = ob_get_clean();
include VIEW_PATH . '/admin/layout.php';
?>
