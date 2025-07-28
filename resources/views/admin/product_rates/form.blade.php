<div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Sản phẩm</label>
            <select select2-modal-ajax ng-model="form.product_id"
                url="{{ route('Product.searchProductAjax') }}" id="product_id"
                placeholder="Chọn sản phẩm" class="form-control"
                modal-selector="<% currentModal %>">
            </select>
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Tên khách hàng</label>
            <input type="text" class="form-control" ng-model="form.name">
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Email khách hàng</label>
            <input type="text" class="form-control" ng-model="form.email">
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Số điện thoại</label>
            <input type="text" class="form-control" ng-model="form.phone">
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Đánh giá (số sao)</label>
            <input type="text" class="form-control" ng-model="form.rating">
        </div>
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Tiêu đề</label>
            <input type="text" class="form-control" ng-model="form.title">
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group custom-group">
            <label class="form-label">Nội dung</label>
            <textarea class="form-control" ng-model="form.desc" rows="5"></textarea>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="form-group text-center">
            <label for="">Hình ảnh đánh giá</label>
            <div class="row gallery-area border">
                <div class="col-md-4 p-2" ng-repeat="g in form.galleries">
                    <div class="gallery-item">
                        <button class="btn btn-sm btn-danger remove" ng-click="form.removeGallery($index)">
                            <i class="fa fa-times mr-0"></i>
                        </button>
                        <div class="form-group">
                            <div class="img-chooser" title="Chọn ảnh">
                                <label for="<% g.image.element_id %>">
                                    <img ng-src="<% g.image.path %>">
                                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="<% g.image.element_id %>">
                                </label>
                            </div>
                            <span class="invalid-feedback d-block" role="alert" ng-if="!errors['galleries.' + $index + '.image_obj']">
                                <strong>
                                    <% errors['galleries.' + $index + '.image' ][0] %>
                                </strong>
                            </span>
                            <span class="invalid-feedback">
                                <strong>
                                    <% errors['galleries.' + $index + '.image_obj' ][0] %>
                                </strong>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 p-2">
                    <label class="gallery-item d-flex align-items-center justify-content-center cursor-pointer" for="gallery-chooser">
                        <i class="fa fa-plus fa-2x text-secondary"></i>
                    </label>
                    <input class="d-none" type="file" accept=".jpg,.png,.jpeg" id="gallery-chooser" multiple>
                </div>
            </div>
            <span class="invalid-feedback">
                <strong>
                    <% errors.galleries[0] %>
                </strong>
            </span>
        </div>
    </div>
</div>
<style>
    .gallery-item {
        padding: 5px;
        padding-bottom: 0;
        border-radius: 2px;
        border: 1px solid #bbb;
        min-height: 100px;
        height: 100%;
        position: relative;
    }
</style>