$(function () {
    $('.deletebtn').on('click', function() {

        const deleteConfirm = confirm('本当に削除しますか？');

        if (deleteConfirm) {
            const $id = $(this).closest('tr').find('#item_id').text();

            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const deleteRequestUrl = "/item/" + $id;
            const deleteRequestData = {
                'id': $id,
                '_method': 'DELETE'
            };

            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN,
                    },
                    type: "POST",
                    url: deleteRequestUrl,
                    data: deleteRequestData,
                })
                .then(
                    function() {
                        alert("削除に成功しました");
                        location.reload();
                    },
                    function() {
                        alert("削除に失敗しました");
                    }
                );
        };
    });
});