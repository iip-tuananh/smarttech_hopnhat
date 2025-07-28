<div class="modal fade" id="create-product-rate" tabindex="-1" role="dialog" aria-hidden="true"
     ng-controller="CreateProductRate">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="semi-bold">Thêm mới đánh giá</h4>
            </div>
            <div class="modal-body" ng-if="currentModal === '#create-product-rate'">
                @include('admin.product_rates.form')
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-cons" ng-click="submit()"
                    ng-disabled="loading.submit">
                    <i ng-if="!loading.submit" class="fa fa-save"></i>
                    <i ng-if="loading.submit" class="fa fa-spin fa-spinner"></i>
                    Lưu
                </button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i
                        class="fas fa-window-close"></i> Hủy</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    app.controller('CreateProductRate', function ($rootScope, $scope, $http, $timeout) {
        $scope.form = new ProductRate({}, {scope: $scope});
        $scope.currentModal = '#create-product-rate';
        $scope.loading = {};

        // Submit Form sửa
        $scope.submit = function () {
            let url = "{{route('product_rates.store')}}";
            let data = $scope.form.submit_data;
            $scope.loading.submit = true;
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                processData: false,
                contentType: false,
                data: data,
                success: function (response) {
                    if (response.success) {
                        $('#create-product-rate').modal('hide');
                        toastr.success(response.message);
                        datatable.ajax.reload();
                        $scope.errors = null;
                    } else {
                        $scope.errors = response.errors;
                        toastr.warning(response.message);
                    }
                },
                error: function () {
                    toastr.error('Đã có lỗi xảy ra');
                },
                complete: function () {
                    $scope.loading.submit = false;
                    $scope.$applyAsync();
                },
            });
        }

        @include('admin.product_rates.formJs')

    })
</script>