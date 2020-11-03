$(function () {
    $('#editImage').on('submit', function (e) {
        e.preventDefault();

        const $id = $('#item_id').val();
        const $image = $('#new_image').val();

        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const putRequestUrl = "/item/" + $id;

        const formData = new FormData($('#editImage').get(0));
        
        formData.append('image', $image);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
            },
            type: "POST",
            url: putRequestUrl,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
        })
            .then(
                () => {
                    $('#edit_item_modal').modal('hide');
                    alert("画像のアップデートに成功しました");
                    location.reload();
                },
                () => {
                    alert("画像のアップデートに失敗しました");
                }
            );
    });
});