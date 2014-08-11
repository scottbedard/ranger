<?php

class ScheduleController extends BaseController {

	function __construct()
	{
		parent::__construct();

		$this->data['date_format'] = 'n/d/Y';
		$this->data['time_format'] = 'g:ia';
	}

	/**
	 * index
	 */
	public function index()
	{
		// Highlight navigation menu
		$this->data['navigation']['schedule']['selected'] = TRUE;

		// No games on the schedule
		if ($this->data['ranger']->game_count == 0) {
			return View::make('schedule.empty');
		}

		// Load rinks
		foreach ($this->data['ranger']->games as $id => $game) {
			$this->data['ranger']->games[$id]->rink = Rink::where('code', $game->code)->first();
		}

		// Display upcoming games
		return View::make('schedule.upcoming')->withData($this->data);
	}

	public function game ( $id )
	{
		// Make sure the game exists
		if (!isset($this->data['ranger']->games[$id])) {
			Flash::warning('We couldn\'t find the game you requested.');
			return Redirect::route('schedule');
		}

		// Hide the travel section if none can be calculated
		$this->data['display_travel'] = FALSE;

		// Load current game
		$this->data['game'] = $this->data['ranger']->games[$id];
		$this->data['rink'] = Rink::where('code', $this->data['game']->code)->first();

		// Look up travel from home base
		if ($this->data['rink'] && !empty($this->data['user']['base'])) {
			$command = new CalcTravelCommand($this->data['user']['base'], $this->data['rink']['zip']);
			$this->data['game']->travel['base'] = $command->execute();
			if ($this->data['game']->travel['base']) $this->data['display_travel'] = TRUE;
		}

		// Load distance from previous game if available
		if ($id > 0) {
			$this->data['prev'] = $this->data['ranger']->games[($id - 1)];
			$this->data['prev']->rink = Rink::where('code', $this->data['prev']->code)->first();

			if (isset($this->data['prev']->rink['zip']) && isset($this->data['game']->rink['zip'])) {
				$command = new CalcTravelCommand($this->data['prev']->rink['zip'], $this->data['rink']['zip']);
				$this->data['game']->travel['prev'] = $command->execute();
				if ($this->data['game']->travel['prev']) $this->data['display_travel'] = TRUE;
			}
		}

		// Load distance to following game if available
		if (!empty($this->data['ranger']->games[($id + 1)])) {
			$this->data['next'] = $this->data['ranger']->games[($id + 1)];
			$this->data['next']->rink = Rink::where('code', $this->data['next']->code)->first();

			if (isset($this->data['next']->rink['zip']) && isset($this->data['game']->rink['zip'])) {
				$command = new CalcTravelCommand($this->data['next']->rink['zip'], $this->data['rink']['zip']);
				$this->data['game']->travel['next'] = $command->execute();
				if ($this->data['game']->travel['next']) $this->data['display_travel'] = TRUE;
			}
		}

		// Load crew phone numbers
		$this->data['contacts'] = [];
		foreach ($this->data['game']->crew->referees as $referee) {
			$official = Official::where('name', $referee)->first();
			if ($official) {
				$this->data['contacts'][$referee]['type'] = (!empty($official->cell)) ? 'phone' : 'house';
				$this->data['contacts'][$referee]['number'] = (!empty($official->cell)) ? $official->cell : $official->home;
			}
		}
		foreach ($this->data['game']->crew->linesmen as $linesman) {
			$official = Official::where('name', $linesman)->first();
			if ($official) {
				$this->data['contacts'][$linesman]['type'] = (!empty($official->cell)) ? 'phone' : 'house';
				$this->data['contacts'][$linesman]['number'] = (!empty($official->cell)) ? $official->cell : $official->home;
			}
		}

		return View::make('schedule.game')->withData($this->data);
	}

}