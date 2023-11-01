<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Collection;
/**
 * Class UserService.
 */
class UserService
{
	public function productUser($id){
		$user = User::with([
			'product'=>function($product){
				$product->orderBy('id', 'desc');
				$product->with('category');
				$product->with('variant');
			}
		])
		->find($id);
		return $user;
	}
}
