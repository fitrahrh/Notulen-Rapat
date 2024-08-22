$(document).ready(function() {
    $('#profile_image').change(function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#profile_image_preview').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
    });
});
