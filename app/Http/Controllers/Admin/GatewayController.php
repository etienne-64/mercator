<?php

namespace App\Http\Controllers\Admin;

use App\Gateway;
use App\Subnetword;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyGatewayRequest;
use App\Http\Requests\StoreGatewayRequest;
use App\Http\Requests\UpdateGatewayRequest;

use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class GatewayController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('gateway_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateways = Gateway::all()->sortBy('name');

        return view('admin.gateways.index', compact('gateways'));
    }

    public function create()
    {
        abort_if(Gate::denies('gateway_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subnetworks = Subnetword::all()->sortBy('name')->pluck('name', 'id');

        return view('admin.gateways.create', compact('subnetworks'));
    }

    public function store(StoreGatewayRequest $request)
    {
        $gateway = Gateway::create($request->all());

        Subnetword::whereIn('id', $request->input('subnetworks', []))
              ->update(['gateway_id' => $gateway->id]);

        return redirect()->route('admin.gateways.index');
    }

    public function edit(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subnetworks = Subnetword::all()->sortBy('name')->pluck('name', 'id');

        return view('admin.gateways.edit', compact('gateway','subnetworks'));
    }

    public function update(UpdateGatewayRequest $request, Gateway $gateway)
    {
        $gateway->update($request->all());

        Subnetword::where('gateway_id', $gateway->id)
              ->update(['gateway_id' => null]);

        Subnetword::whereIn('id', $request->input('subnetworks', []))
              ->update(['gateway_id' => $gateway->id]);

        return redirect()->route('admin.gateways.index');
    }

    public function show(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateway->load('gatewaySubnetwords');

        return view('admin.gateways.show', compact('gateway'));
    }

    public function destroy(Gateway $gateway)
    {
        abort_if(Gate::denies('gateway_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $gateway->delete();

        return back();
    }

    public function massDestroy(MassDestroyGatewayRequest $request)
    {
        Gateway::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

}
