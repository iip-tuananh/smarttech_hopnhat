$(document).on('change', '#gallery-chooser', function (e) {
    const files = Array.from(this.files);

    if (!files.length) return;

    files.forEach(file => {
        let item = $scope.form.addGallery({});

        // Chờ AngularJS render xong DOM
        $timeout(() => {
            const input = document.getElementById(item.image.element_id);
            if (input) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                input.files = dataTransfer.files;
                $(input).trigger('change'); // kích hoạt upload/preview nếu có
                item.image.path = URL.createObjectURL(file);
                $scope.$apply();
            } else {
                console.warn('Không tìm thấy input với ID:', item.image.element_id);
            }
        }, 0); // delay 0ms vẫn sẽ đợi render xong
    });

    $scope.$apply(); // để AngularJS nhận biết model thay đổi
});
