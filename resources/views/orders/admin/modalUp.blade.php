<div id="order_modal_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <h4 id="exampleModalLabel" class="modal-title">Обновление заказа №<span id="numOrd1"></span></h4>
                <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                    <label id="ordNUM1" alt="" style="display: none"></label>

                <div class="form-group">
                    <label>Направление</label>
                    <select name="way" class="form-control rounded" id="way">
                        <option value="1">Банкротство</option>
                        <option value="2">Кредитование</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Количество лидов</label>
                    <input type="text" id="quantity" name="quantity" class="form-control">
                </div>


                <input type="text" name="orderid" value="{{--{{$order->id}}--}}" hidden>
                <div class="form-group">
                    <label>Суточный лимит лидов</label>
                    <input type="text" id="limit_lid" name="limit_lid" class="form-control">
                </div>
                @if(auth()->user()->role > 1)

                <div class="form-group">
                    <label class="form-control-label">Регионы/города</label>
                    <div class="select mb-i">
                        <select id="region1" name="region1" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                multiple data-actions-box="true"
                                data-none-Selected-Text="Выберите регион"
                                data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">
                        </select>

                        <select id="city1" name="city1" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                multiple data-actions-box="true"
                                data-none-Selected-Text="Выберите города"
                                data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">

                        </select>

                    </div>
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Отмена</button>
                <div class="btn btn-primary" id="upOrder" data-order="{{--{{$order->id}}--}}">Обновить заказ</div>
            </div>
        </div>
    </div>
</div>