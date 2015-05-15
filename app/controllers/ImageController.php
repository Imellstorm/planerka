<?php

class ImageController extends BaseController {


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		Image::destroy($id);
		return Redirect::back();
	}

}