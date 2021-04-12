<div id="order_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left" style="display: none;">
    <div role="document" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                @if($_SERVER['REQUEST_URI']=='/orders')
                <h4 id="exampleModalLabel" class="modal-title">Добавить лида к заказу №<span id="numOrd"></span></h4>@endif
                    @if($_SERVER['REQUEST_URI']=='/leads')
                        <h4 id="exampleModalLabel" class="modal-title">Добавить Лид</h4>
                        @endif
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
               {{-- <form id="form_order{{$order->id}}">
                    @csrf--}}
                @if($_SERVER['REQUEST_URI']=='/orders')
                <label id="ordNUM" alt="" style="display: none"></label>
                @endif
                    <input type="text" name="orderid" value="{{--{{$order->id}}--}}" hidden>
                    <div class="form-group">
                        <label class="form-control-label">Направление</label>
                        <div class="select mb-3">
                            <select id="way" name="way" class="form-control rounded">
                                <option value="1">Банкротство</option>
                                <option value="2">Кредитование</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Фамилия Имя Отчество (ФИО)</label>
                        <input type="text" id="fio" name="fullname" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="form-control-label">Регионы/города</label>
                        <div class="select mb-i">
                            <select id="region" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                    multiple data-actions-box="true"
                                    data-none-Selected-Text="Выберите регион"
                                    data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                    data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">
                            </select>

                            <select id="city" name="city" class="selectpicker" data-style="btn-primary" data-live-search="true"
                                    multiple data-actions-box="true"
                                    data-none-Selected-Text="Выберите города"
                                    data-select-all-text="<span style='color:black'><b>V</b> всё</span>"
                                    data-deselect-all-text="<span style='color:black'><b>X</b> Отмена</span>">

                            </select>

                        </div>
                    </div>
                    <div class="form-group">
                        <label>Телефон</label>
                        <input type="text" id="phone" name="telephone" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Сумма</label>
                        <input type="text" id="sum" name="sum" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Комментарий</label>
                        <textarea class="form-control rounded-0" name="comment" id="comment"{{--id="exampleFormControlTextarea1"--}} rows="3"></textarea>
                    </div>
                {{--</form>--}}
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-secondary">Отмена</button>
                <div class="btn btn-primary" id="addLead" data-order="{{--{{$order->id}}--}}">Добавить лида</div>
            </div>
        </div>
    </div>
</div>

