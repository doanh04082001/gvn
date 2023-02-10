<table class="table table-bordered">
    <thead>
    <tr>
        <th class="col-3">
            {{ __('pages.product.table.name') }}
            <span class="text-danger">*</span>
        </th>
        <th class="col-4">
            {{ __('pages.product.table.price') }}
            <span class="text-danger">*</span>
        </th>
        <th class="col-4">
            {{ __('pages.product.table.sale_price') }}
            <span class="text-danger">*</span>
        </th>
        <th class="col-1 text-center">{{ __('app.action') }}</th>
    </tr>
    </thead>
    <template v-for="(item, index) in variants">
        <tr>
            <td>
                <input v-model="variants[index].name" type="text" class="form-control form-control-sm">
                <span class="text-red small">@{{ errors?.variantErrs[index]?.name }}</span>
            </td>
            <td class="text-center">
                <div v-if="variants[index].id && variants[index].id != ''">
                    <button class="btn btn-outline-primary btn-sm"
                            :data-id="variants[index].id"
                            :data-name="variants[index].name"
                            @click="handleButtonEditPriceEvent($event)"
                    >
                        <i class="fa fa-edit"></i> {{ __('pages.product.change_price_store') }}
                    </button>
                </div>
                <div v-else>
                    <input :value="variantsPriceDisplay[index]"
                           @input="variantsPriceDisplay = { index, value: $event.target.value }"
                           maxlength="15"
                           type="text" class="form-control form-control-sm">
                    <span class="text-red small float-left">@{{ errors?.variantErrs[index]?.price }}</span>
                </div>
            </td>
            <td class="text-center">
                <div v-if="variants[index].id && variants[index].id != ''" class="container">
                    <button class="btn btn-outline-primary btn-sm"
                            :data-id="variants[index].id"
                            :data-name="variants[index].name"
                            @click="handleButtonEditPriceEvent($event)"
                    >
                        <i class="fa fa-edit"></i> {{ __('pages.product.change_price_store') }}
                    </button>
                </div>
                <div v-else>
                    <input :value="variantsSalePriceDisplay[index]"
                           @input="variantsSalePriceDisplay = {index, value: $event.target.value }"
                           maxlength="15"
                           type="text" class="form-control form-control-sm">
                    <span class="text-red small float-left">@{{ errors?.variantErrs[index]?.sale_price }}</span>
                </div>
            </td>
            <td class="text-center">
                <button class="btn btn-outline-danger"
                        @click="removeVariant(index)"><i
                            class="fa fa-times-circle"></i></button>
            </td>
        </tr>
    </template>
</table>
<button class="btn btn-primary btn-sm mt-2" @click="addVariant()"><i
            class="fa fa-plus-circle"></i></button>
