<?php

namespace App\Http\Controllers\API\v1;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseApiController;
use App\Repositories\Admin\UserRepository;

class UserApiController extends BaseApiController
{
    public function __construct(private UserRepository $userRepository) {
        //
    }

    public function profile()
    {
        $user = auth('sanctum')->user();
        return $this->sendSuccessResponse('Profile fetched successfully!', $user);
    }

    public function updateProfile(Request $request)
    {
        $user = auth('sanctum')->user();
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|min:2|max:30',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'phone' => 'sometimes|numeric|digits:10|unique:users,phone,' . $user->id,
        ]);

        if($validator->fails()){
            return $this->sendFailedResponse('All Fields are required', self::HTTP_UNPROCESSABLE, $validator->errors() );
        }

        $this->userRepository->update($user->id, $validator->validated());

        return $this->sendSuccessResponse(
            'Profile fetched successfully!',
            array_merge($user->toArray(), $validator->validated())
        );
    }
}
