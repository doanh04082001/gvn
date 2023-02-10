<div class="row">
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.name') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                <input v-model="product.name" type="text"
                       class="form-control">
                <span class="text-red small">@{{ errors?.productErrs?.name }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.sku') }}
            </label>
            <div class="col-sm-9">
                <input v-model="product.sku" type="text"
                       class="form-control">
                <span class="text-red small">@{{ errors?.productErrs?.sku }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.taxonomy') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                <select v-model="product.category_id" class="form-control">
                    @foreach($taxonomies as $taxonomy)
                        <option value="{{ $taxonomy->id }}">{{ $taxonomy->name }}</option>
                    @endforeach
                </select>
                <span class="text-red small">@{{ errors?.productErrs?.category_id }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.unit') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                <select v-model="product.unit_id" class="form-control">
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                    @endforeach
                </select>
                <span class="text-red small">@{{ errors?.productErrs?.unit_id }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.price') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                @if ($isEdit)
                    <button class="btn btn-outline-primary btn-sm"
                            :data-id="product.id"
                            :data-name="product.name"
                            @click="handleButtonEditPriceEvent($event)">
                        <i class="fa fa-edit"></i> {{ __('pages.product.change_price_store') }}
                    </button>
                @else
                    <input v-model="priceDisplay" type="text" maxlength="15" class="form-control">
                    <span class="text-red small">@{{ errors?.productErrs?.price }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.sale_price') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                @if ($isEdit)
                    <button class="btn btn-outline-primary btn-sm"
                            :data-id="product.id"
                            :data-name="product.name"
                            @click="handleButtonEditPriceEvent($event)">
                        <i class="fa fa-edit"></i> {{ __('pages.product.change_price_store') }}
                    </button>
                @else
                    <input v-model="salePriceDisplay" type="text" maxlength="15" class="form-control">
                    <span class="text-red small">@{{ errors?.productErrs?.sale_price }}</span>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.cost') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                <input v-model="costDisplay" type="text" maxlength="15" class="form-control">
                <span class="text-red small">@{{ errors?.productErrs?.cost }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.description') }}
            </label>
            <div class="col-sm-9">
                <textarea v-model="product.description" name="description" class="form-control"></textarea>
                <span class="text-red small">@{{ errors?.productErrs?.description }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.order') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-9">
                <input type="number" maxlength="4" min="1" class="form-control col-sm-2" name="order" v-model="product.order" />
                <span class="text-red small">@{{ errors?.productErrs?.order }}</span>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.is_combo') }}
            </label>
            <div class="col-sm-9 d-flex align-items-center">
                <input type="checkbox" v-model="product.is_combo" name="is_combo" @change="!product.is_combo">
                <div class="text-red small">@{{ errors?.productErrs?.is_combo }}</div>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-3 col-form-label">
                {{ __('pages.product.sale_form') }}
            </label>
            <div class="col-sm-9 d-flex align-items-center flex-wrap">
                <label>
                    <input type="checkbox" v-model="product.is_online" name="is_online" @change="!product.is_online"> Online
                </label>
                <div class="text-red small w-100">@{{ errors?.productErrs?.is_online }}</div> 
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group row">
            <label class="col-sm-12 col-form-label">
                {{ __('pages.product.avatar') }}
                <span class="text-danger">*</span>
            </label>
            <div class="col-sm-12">
                <preview-image
                        @file-changed="onFileChange($event)"
                        :image="product.image_url"
                >
                </preview-image>
            </div>
            <div class="col-sm-12">
                <span class="text-red small ml-3">@{{ errors?.productErrs?.image }}</span>
            </div>
        </div>
    </div>
</div>
