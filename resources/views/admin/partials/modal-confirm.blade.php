<div id="app-store-product">
    <div class="modal fade" id="store-product-modal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('pages.product.edit_price_product') }} "@{{ product_name }}"</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- <div class="table-fixed-height">
                        <table id="store-product-table" class="table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>{{ __('pages.store.name') }}</th>
                                    <th>{{ __('pages.store.price') }}</th>
                                    <th>{{ __('pages.store.sale_price') }}</th>
                                    <th>{{ __('pages.store.save_price') }}</th>
                                    <th>{{ __('pages.store.featured') }}</th>
                                    <th>{{ __('pages.store.status') }}</th>
                                </tr>
                                <tr>
                                    <th><input type="text" class="form-control form-control-sm"></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select v-model="featured" class="form-control form-control-sm">
                                            <option value="">{{ __('app.show_all_text') }}</option>
                                            @foreach (__('pages.product.featured_option') as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                    <th>
                                        <select v-model="status" class="form-control form-control-sm">
                                            <option value="">{{ __('app.show_all_text') }}</option>
                                            @foreach (__('pages.product.status_option') as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="h-400">
                            </tbody>
                        </table>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-right">
                    <button type="button" class="btn btn-outline-secondary btn-sm pl-4 pr-4"
                        data-dismiss="modal">{{ __('app.cancel_button_text') }}</button>
                    @can('products.edit')
                        <button type="button" @click="saveAll"
                            class="btn btn-outline-success btn-sm pl-4 pr-4">{!! __('app.save_button_text') !!}</button>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
