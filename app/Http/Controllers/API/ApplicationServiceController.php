<?php

namespace App\Http\Controllers\API;

use App\ApplicationService;

use App\Http\Requests\StoreApplicationServiceRequest;
use App\Http\Requests\UpdateApplicationServiceRequest;
use App\Http\Requests\MassDestroyApplicationServiceRequest;
use App\Http\Resources\Admin\ApplicationServiceResource;

use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Log;

class ApplicationServiceController extends Controller
{
    public function index()
    {
    abort_if(Gate::denies('applicationservice_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    $applicationservices = ApplicationService::all();

    return response()->json($applicationservices);
    }

    public function store(StoreApplicationServiceRequest $request)
    {
        abort_if(Gate::denies('applicationservice_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $applicationservice = ApplicationService::create($request->all());
        $applicationService->modules()->sync($request->input('modules', []));
        $applicationService->applications()->sync($request->input('applications', []));

        return response()->json($applicationservice, 201);
    }

    public function show(ApplicationService $applicationservice)
    {
        abort_if(Gate::denies('applicationservice_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ApplicationServiceResource($applicationservice);
    }

    public function update(UpdateApplicationServiceRequest $request, ApplicationService $applicationservice)
    {     
        abort_if(Gate::denies('applicationservice_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $applicationservice->update($request->all());
        $applicationService->modules()->sync($request->input('modules', []));
        $applicationService->applications()->sync($request->input('applications', []));

        return response()->json();
    }

    public function destroy(ApplicationService $applicationservice)
    {
        abort_if(Gate::denies('applicationservice_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $applicationservice->delete();

        return response()->json();
    }

    public function massDestroy(MassDestroyApplicationServiceRequest $request)
    {
        ApplicationService::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}

