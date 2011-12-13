<?php

namespace AdminModule;

use Nette\Http\User;


final class DefaultPresenter extends BasePresenter
{

	public function startup()
	{
		parent::startup();

		if (!$this->user->isLoggedIn()) {
			if ($this->user->getLogoutReason() === User::INACTIVITY) {
				$this->flashMessage('Session timeout, you have been logged out', 'warning');
			}

			$backlink = $this->getApplication()->storeRequest();
			$this->redirect('Auth:login', array('backlink' => $backlink));
		} else {
			if (!$this->user->isAllowed($this->name, $this->action)) {
				$this->flashMessage('Access diened. You don\'t have permissions to view that page.', 'warning');
				$this->redirect('Auth:login');
			}
		}
	}


	public function actionLogout()
	{
		$this->user->logOut();
		$this->redirect('Auth:login');
	}

}
