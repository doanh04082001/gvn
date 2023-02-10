<table class="table table-bordered">
    <thead>
    <tr>
        <th class="col-5">
            {{ __('pages.product.table.name') }}
            <span class="text-danger">*</span>
        </th>
        <th class="col-5">
            {{ __('pages.product.table.quantity') }}
            <span class="text-danger">*</span>
        </th>
        <th class="col-2 text-center">{{ __('app.action') }}</th>
    </tr>
    </thead>
    <template v-for="(item, index) in combos">
        <tr>
            <td>
                <v-select class="vue-select2 vue-select-sm" name="select2"
                          :options="{{ $productComboOptions->toJson() }}"
                          label="full_name"
                          :value="combos[index]"
                          @input="setComboSelected($event, index)"
                >
                </v-select>
                <span class="text-red small">@{{ errors?.comboErrs[index]?.full_name }}</span>
            </td>
            <td>
                <input type="text"
                       :value="comboQuantityDisplay[index]"
                       @input="comboQuantityDisplay = {index, value: $event.target.value }"
                       class="form-control form-control-sm">
                <span class="text-red small">@{{ errors?.comboErrs[index]?.quantity }}</span>
            </td>
            <td class="text-center">
                <button class="btn btn-outline-danger"
                        @click="removeProductCombo(index)"><i
                            class="fa fa-times-circle"></i></button>
            </td>
        </tr>
    </template>

</table>
<button class="btn btn-primary btn-sm mt-2" @click="addProductCombo"><i
            class="fa fa-plus-circle"></i></button>
