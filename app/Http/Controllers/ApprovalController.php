<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;
use App\Models\Approval;
use App\Models\Procuring;
use App\Models\Requisition;

class ApprovalController extends Controller
{
    public function search(Request $req)
    {
        /** Get params from query string */
        $type       = $req->get('type');
        $category   = $req->get('category');
        $group       = $req->get('group');
        $name       = $req->get('name');
        $owner      = $req->get('owner');
        $status     = $req->get('status');

        $assets = Asset::with('group','group.category','brand','budget','obtaining','unit','room')
                    ->with('currentOwner','currentOwner.owner','currentOwner.owner.prefix')
                    // ->when(!empty($type), function($q) use ($type) {
                    //     $q->where('asset_type_id', $type);
                    // })
                    ->when(!empty($category), function($q) use ($category) {
                        $q->where('asset_category_id', $category);
                    })
                    ->when(!empty($group), function($q) use ($group) {
                        $q->where('asset_group_id', $group);
                    })
                    ->when(!empty($name), function($q) use ($name) {
                        $q->where('name', 'like', '%'.$name.'%');
                    })
                    ->when(!empty($owner), function($q) use ($owner) {
                        $q->whereHas('currentOwner', function($sq) use ($owner) {
                            $sq->where('owner_id', $owner);
                        });
                    })
                    ->when(!empty($status), function($q) use ($status) {
                        $q->where('status', $status);
                    })
                    ->paginate(10);

        return $assets;
    }

    public function getAll(Request $req)
    {
        /** Get params from query string */
        $type       = $req->get('type');
        $category   = $req->get('category');
        $group      = $req->get('group');
        $name       = $req->get('name');
        $owner      = $req->get('owner');
        $status     = $req->get('status');

        $assets = Asset::with('group','group.category','brand','budget','obtaining','unit','room')
                    ->with('currentOwner','currentOwner.owner','currentOwner.owner.prefix')
                    // ->when(!empty($type), function($q) use ($type) {
                    //     $q->where('asset_type_id', $type);
                    // })
                    ->when(!empty($category), function($q) use ($category) {
                        $q->where('asset_category_id', $category);
                    })
                    ->when(!empty($group), function($q) use ($group) {
                        $q->where('asset_group_id', $group);
                    })
                    ->when(!empty($name), function($q) use ($name) {
                        $q->where('name', 'like', '%'.$name.'%');
                    })
                    ->when(!empty($owner), function($q) use ($owner) {
                        $q->whereHas('currentOwner', function($sq) use ($owner) {
                            $sq->where('owner_id', $owner);
                        });
                    })
                    ->when(!empty($status), function($q) use ($status) {
                        $q->where('status', $status);
                    })
                    ->get();

        return $assets;
    }

    public function getById($id)
    {
        return Asset::with('group','group.category','brand','budget', 'obtaining','unit','room')->find($id);
    }

    public function getInitialFormData()
    {
        return [
            'procurings'         => Procuring::all(),
        ];
    }

    public function store(Request $req)
    {
        try {
            $asset = new Asset();
            $asset->asset_no            = $req['asset_no'];
            $asset->name                = $req['name'];
            $asset->description         = $req['description'];
            $asset->asset_category_id   = $req['asset_category_id'];
            $asset->asset_group_id      = $req['asset_group_id'];
            $asset->price               = $req['price'];
            $asset->unit_id             = $req['unit_id'];
            $asset->brand_id            = $req['brand_id'];
            $asset->model               = $req['model'];
            $asset->purchased_at        = $req['purchased_at'];
            $asset->date_in             = $req['date_in'];
            $asset->first_year          = $req['first_year'];
            $asset->obtain_type_id      = $req['obtain_type_id'];
            $asset->budget_id           = $req['budget_id'];
            $asset->location            = $req['location'];
            $asset->room_id             = $req['room_id'];
            $asset->remark              = $req['remark'];
            $asset->status              = 1;

            if ($req->file('img_url')) {
                $file = $req->file('img_url');
                $fileName = date('mdYHis') . uniqid(). '.' .$file->getClientOriginalExtension();
                $destinationPath = 'uploads/assets/';

                if ($file->move($destinationPath, $fileName)) {
                    $asset->img_url = $fileName;
                }
            }

            if($asset->save()) {
                return [
                    'status'    => 1,
                    'message'   => 'Insertion successfully!!',
                    'asset'     => $asset
                ];
            } else {
                return [
                    'status'    => 0,
                    'message'   => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status'    => 0,
                'message'   => $ex->getMessage()
            ];
        }
    }

    public function update(Request $req, $id)
    {
        try {
            $asset = Asset::find($id);
            $asset->asset_no            = $req['asset_no'];
            $asset->name                = $req['name'];
            $asset->description         = $req['description'];
            $asset->asset_category_id   = $req['asset_category_id'];
            $asset->asset_group_id      = $req['asset_group_id'];
            $asset->price               = $req['price'];
            $asset->unit_id             = $req['unit_id'];
            $asset->brand_id            = $req['brand_id'];
            $asset->model               = $req['model'];
            $asset->purchased_at        = $req['purchased_at'];
            $asset->date_in             = $req['date_in'];
            $asset->first_year          = $req['first_year'];
            $asset->obtain_type_id      = $req['obtain_type_id'];
            $asset->budget_id           = $req['budget_id'];
            $asset->location            = $req['location'];
            $asset->room_id             = $req['room_id'];
            $asset->remark              = $req['remark'];

            if($asset->save()) {
                return [
                    'status'    => 1,
                    'message'   => 'Updating successfully!!',
                    'asset'     => $asset
                ];
            } else {
                return [
                    'status'    => 0,
                    'message'   => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status'    => 0,
                'message'   => $ex->getMessage()
            ];
        }
    }

    public function destroy(Request $req, $id)
    {
        try {
            $asset = Asset::find($id);

            if($asset->delete()) {
                return [
                    'status'     => 1,
                    'message'    => 'Deleting successfully!!',
                    'id'         => $id
                ];
            } else {
                return [
                    'status'    => 0,
                    'message'   => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status'    => 0,
                'message'   => $ex->getMessage()
            ];
        }
    }

    public function uploadImage(Request $req, $id)
    {
        try {
            $asset = Asset::find($id);

            if ($req->file('img_url')) {
                $file = $req->file('img_url');
                $fileName = date('mdYHis') . uniqid(). '.' .$file->getClientOriginalExtension();
                $destinationPath = 'uploads/assets/';

                /** Remove old uploaded file */
                if (\File::exists($destinationPath . $asset->img_url)) {
                    \File::delete($destinationPath . $asset->img_url);
                }

                /** Upload new file */
                if ($file->move($destinationPath, $fileName)) {
                    $asset->img_url = $fileName;
                }
            }

            if($asset->save()) {
                return [
                    'status'    => 1,
                    'message'   => 'Uploading avatar successfully!!',
                    'img_url'   => $asset->img_url
                ];
            } else {
                return [
                    'status'    => 0,
                    'message'   => 'Something went wrong!!'
                ];
            }
        } catch (\Exception $ex) {
            return [
                'status'    => 0,
                'message'   => $ex->getMessage()
            ];
        }
    }
}
