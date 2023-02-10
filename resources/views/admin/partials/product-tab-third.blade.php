<table class="table table-bordered">
    <thead>
    <tr>
        <th>
            {{ __('pages.product.table.name') }}
            <span class="text-danger">*</span>
        </th>
        <th>{{ __('app.action') }}</th>
    </tr>
    </thead>
    <template v-for="(item, index) in toppings">
        <tr>
            <td>
                <v-select class="vue-select2 vue-select-sm" name="select2"
                          :options="toppingOptions"
                          label="name"
                          v-model="toppings[index]"
                >
                </v-select>
                <span class="text-red small">@{{ errors?.toppingErrs[index]?.name }}</span>
            </td>
            <td>
                <button class="btn btn-outline-danger"
                        @click="removeTopping(index)"><i
                            class="fa fa-times-circle"></i></button>
            </td>
        </tr>
    </template>

</table>
<button class="btn btn-primary btn-sm mt-2" @click="addTopping()"><i
            class="fa fa-plus-circle"></i></button>
