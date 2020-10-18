$(function () {
    $('#addItem').on('submit', function (e) {
        e.preventDefault();

        const $title = $('#add_title').val();
        const $image = $('#add_image').val();
        const $description = $('#add_description').val();
        const $price = $('#add_price').val();

        if ($.isEmptyObject($title) || $.isEmptyObject($image) || $.isEmptyObject($description) || $.isEmptyObject($price)) {
            alert('未入力の項目があります');
        } else {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const postRequestUrl = "/item";

            const formData = new FormData($('#addItem').get(0));

            formData.append('title', $title);
            formData.append('image', $image);
            formData.append('description', $description);
            formData.append('price', $price);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN,
                },
                type: "POST",
                url: postRequestUrl,
                data: formData,
                contentType: false,
                processData: false,
            })
                .then(
                    () => {
                        $('#edit_item_modal').modal('hide');
                        alert("保存に成功しました");
                        location.reload();
                    },
                    () => {
                        alert("保存に失敗しました");
                    }
                );
        }
    });
});