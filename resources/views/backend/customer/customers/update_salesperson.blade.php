<form id="add_Child_product" method="POST">
<div class="card">
    <div class="card-body">    
        <div class="form-group row">
            <label class="col-md-2 col-from-label">Salesperson</label>
            <div class="col-md-8">
                <select class="form-control aiz-selectpicker" onchange="add_Child(this)" name="child_product[]" id="child_product" data-selected-text-format="count" data-live-search="true" multiple data-placeholder="{{ translate('Choose Product') }}" data-mainid="{{$mainid}}">
                    @foreach($allSalespersonData as $key => $allSalesperson)
                        <option value="{{$allSalesperson['id']}}">{{$allSalesperson['name']}}</option>
                    @endforeach
                </select>
                <input type="hidden" name="mainid" value="{{$mainid}}">
            </div>
        </div>
    </div>
</div>
</form>
 
<script src="{{ static_asset('assets/js/aiz-core.js') }}" ></script>
