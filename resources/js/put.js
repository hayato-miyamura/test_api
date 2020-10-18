$(function () {
    $('#editItem').on('submit', function (e) {
        e.preventDefault();

        const $id = $('#id').val();
        const $title = $('#title').val();
        const $image = $('#image').val();
        const $description = $('#description').val();
        const $price = $('#price').val();

        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const putRequestUrl = "/item/" + $id;

        const formData = new FormData($('#editItem').get(0));

        formData.append('title', $title);
        formData.append('image', $image);
        formData.append('description', $description);
        formData.append('price', $price);

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
                    alert("アップデートに成功しました");
                    location.reload();
                },
                () => {
                    alert("アップデートに失敗しました");
                }
            );
    });
});