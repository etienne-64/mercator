@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.process.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.processes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="identifiant">{{ trans('cruds.process.fields.identifiant') }}</label>
                <input class="form-control {{ $errors->has('identifiant') ? 'is-invalid' : '' }}" type="text" name="identifiant" id="identifiant" value="{{ old('identifiant', '') }}" required>
                @if($errors->has('identifiant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('identifiant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.process.fields.identifiant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="recommended" for="description">{{ trans('cruds.process.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description') !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.process.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="recommended" for="in_out">{{ trans('cruds.process.fields.in_out') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('in_out') ? 'is-invalid' : '' }}" name="in_out" id="in_out">{!! old('in_out') !!}</textarea>
                @if($errors->has('in_out'))
                    <div class="invalid-feedback">
                        {{ $errors->first('in_out') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.process.fields.in_out_helper') }}</span>
            </div>


          <div class="row">
            <div class="col-sm">


                <div class="form-group">
                    <label for="activities">{{ trans('cruds.process.fields.activities') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('activities') ? 'is-invalid' : '' }}" name="activities[]" id="activities" multiple>
                        @foreach($activities as $id => $activities)
                            <option value="{{ $id }}" {{ in_array($id, old('activities', [])) ? 'selected' : '' }}>{{ $activities }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('activities'))
                        <div class="invalid-feedback">
                            {{ $errors->first('activities') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.activities_helper') }}</span>
                </div>
                
                <div class="form-group">
                    <label for="entities">{{ trans('cruds.process.fields.entities') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('entities') ? 'is-invalid' : '' }}" name="entities[]" id="entities" multiple>
                        @foreach($entities as $id => $entities)
                            <option value="{{ $id }}" {{ in_array($id, old('entities', [])) ? 'selected' : '' }}>{{ $entities }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('entities'))
                        <div class="invalid-feedback">
                            {{ $errors->first('entities') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.entities_helper') }}</span>
                </div>

                <div class="form-group">
                    <label for="entities">{{ trans('cruds.process.fields.informations') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('informations') ? 'is-invalid' : '' }}" name="informations[]" id="informations" multiple>
                        @foreach($informations as $id => $informations)
                            <option value="{{ $id }}" {{ in_array($id, old('informations', [])) ? 'selected' : '' }}>{{ $informations }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('informations'))
                        <div class="invalid-feedback">
                            {{ $errors->first('informations') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.informations_helper') }}</span>
                </div>

            </div>
            <div class="col-sm">

                <div class="form-group">
                    <label class="recommended" for="security_need">{{ trans('cruds.process.fields.security_need') }}</label>
                    <select class="form-control select2 {{ $errors->has('security_need') ? 'is-invalid' : '' }}" name="security_need" id="security_need">
                        <option value="0"></option>
                        <option value="1" {{ old('security_need') == 1 ? 'selected' : '' }}>Public</option>
                        <option value="2" {{ old('security_need') == 2 ? 'selected' : '' }}>Internal</option>
                        <option value="3" {{ old('security_need') == 3 ? 'selected' : '' }}>Confidential</option>
                        <option value="4" {{ old('security_need') == 4 ? 'selected' : '' }}>Secret</option>
                    </select>                
                    @if($errors->has('security_need'))
                        <div class="invalid-feedback">
                            {{ $errors->first('security_need') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.security_need_helper') }}</span>
                </div>

                <div class="form-group">
                    <label class="recommended" for="macroprocessus_id">{{ trans('cruds.process.fields.macroprocessus') }}</label>
                    <select class="form-control select2 {{ $errors->has('macroprocessus') ? 'is-invalid' : '' }}" name="macroprocess_id" id="macroprocess_id">
                        <option></option>
                        @foreach($macroProcessuses as $id => $macroprocessus)
                            <option value="{{ $id }}" {{ old('macroprocessus_id') == $id ? 'selected' : '' }}>{{ $macroprocessus }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('macroprocessus'))
                        <div class="invalid-feedback">
                            {{ $errors->first('macroprocessus') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.macroprocessus_helper') }}</span>
                </div>



                <div class="form-group">
                    <label class="recommended" for="owner">{{ trans('cruds.process.fields.owner') }}</label>
                    <select class="form-control select2-free {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner" id="owner">
                        @if (!$owner_list->contains(old('owner')))
                            <option> {{ old('owner') }}</option>'
                        @endif
                        @foreach($owner_list as $t)
                            <option {{ old('owner') == $t ? 'selected' : '' }}>{{$t}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('owner'))
                        <div class="invalid-feedback">
                            {{ $errors->first('owner') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.process.fields.owner_helper') }}</span>
                </div>
            </div>
        </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
$(document).ready(function () {

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: []
      }
    );
  }

  $(".select2-free").select2({
        placeholder: "{{ trans('global.pleaseSelect') }}",
        allowClear: true,
        tags: true
    }) 

});
</script>
@endsection