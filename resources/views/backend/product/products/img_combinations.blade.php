@if(count($options[0]) > 0)
<table class="table table-bordered aiz-table">
	<thead>
		<tr>
			<td class="text-center">
				{{translate('Variant')}}
			</td>
			<td class="text-center">
				{{translate('Image')}}
			</td>
		</tr>
	</thead>
	<tbody>
	@foreach ($options as $key => $combination)
		@foreach ($combination as $key => $item)
			<tr class="variant">
				<td>
					<label for="" class="control-label">{{ $item }}</label>
				</td>
				<td>
					<div class="input-group" data-toggle="aizuploader" data-type="image" data-multiple="true">
						<div class="input-group-prepend">
							<div class="input-group-text bg-soft-secondary font-weight-medium">{{ translate('Browse')}}</div>
						</div>
						<div class="form-control file-amount">{{ translate('Choose File') }}</div>
						<input type="hidden" name="variant_images[{{$item}}][]" class="selected-files">
					</div>
					<div class="file-preview box sm">
					</div>
				</td>
				
			</tr>
		
		@endforeach
	@endforeach
	</tbody>
</table>
@endif
