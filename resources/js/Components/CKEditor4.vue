<template>
    <div>
        <div id="editor2"></div>

    </div>
</template>

<script>

// Note: in this sample we use CKEditor with two extra plugins:
// - uploadimage to support pasting and dragging images,
// - image2 (instead of image) to provide images with captions.
// Additionally, the CSS style for the editing area has been slightly modified to provide responsive images during editing.
// All these modifications are not required by CKFinder, they just provide better user experience.
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.disableAutoInline = true;
    CKEDITOR.addCss('img {max-width:100%; height: auto;}');
    var editor = CKEDITOR.replace('editor2', {
        extraPlugins: 'uploadimage,image2',
        removePlugins: 'image',
        height: 250
    });
    CKFinder.setupCKEditor(editor);
} else {
    document.getElementById('editor2').innerHTML =
        '<div class="tip-a tip-a-alert">This sample requires working Internet connection to load CKEditor 4 from CDN.</div>'
}
</script>

<style></style>
