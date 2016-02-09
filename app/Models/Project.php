<?php namespace App\Models;

class Project extends Model {
	
	const STATE_READY = 1;
	const STATE_READY_AFTER_FUNDING = 2;
	const STATE_UNDER_INVESTIGATION = 3;
	const STATE_APPROVED = 4;
	
	protected static $fillableByState = [
		Project::STATE_READY => [
			'title', 'alias', 'description', 'video_url', 'story',
			'detailed_address', 'concert_hall', 'pledged_amount', 'audiences_limit', 
			'funding_closing_at'
		],
		
		Project::STATE_READY_AFTER_FUNDING => [
			'description', 'video_url', 'story',
			'detailed_address', 'concert_hall', 'audiences_limit'
		],
		
		Project::STATE_UNDER_INVESTIGATION => [
			// nothing can update
		],
		
		Project::STATE_APPROVED => [
			'description', 'video_url', 'story'
		]
	];
	
	protected static $typeRules = [
		'title' => 'string|min:1|max:30',
		'alias' => 'regex:/^[a-zA-Z]{1}[a-zA-Z0-9-_]{3,63}$/',
		'poster_url' => 'url',
		'description' => 'string',
		'video_url' => 'url',
		'detailed_address' => 'string',
		'concert_hall' => 'string',
		'pledged_amount' => 'integer|min:0',
		'audiences_limit' => 'integer|min:0',
		'funding_closing_at' => 'date_format:Y-m-d',
		'performance_opening_at' => 'date_format:Y-m-d'
	];
	
	public function update(array $attributes = array()) {
		$this->fillable = static::$fillableByState[$this->state];
		parent::update($attributes);
	}
	
	public function submit() {
		if ((int) $this->state === Project::STATE_READY ||
			(int) $this->state === Project::STATE_READY_AFTER_FUNDING) {
			$this->setAttribute('state', Project::STATE_UNDER_INVESTIGATION);
			$this->save();
		}
	}
	
	public function approve() {
		$this->setAttribute('state', Project::STATE_APPROVED);
		$this->save();
	}
	
	public function reject() {
		if ($this->type === 'funding') {
			$this->setAttribute('state', Project::STATE_READY);
		} else if ($this->type === 'sale') {
			if ($this->funding_closing_at) {
				$this->setAttribute('state', Project::STATE_READY_AFTER_FUNDING);
			} else {
				$this->setAttribute('state', Project::STATE_READY);
			}
		}
		$this->save();
	}
	
	public function category() {
		return $this->belongsTo('App\Models\Category');
	}

	public function organization() {
		return $this->belongsTo('App\Models\Organization');
	}

	public function user() {
		return $this->belongsTo('App\Models\User');
	}
	
	public function city() {
		return $this->belongsTo('App\Models\City');
	}

	public function tickets() {
		if ($this->type === 'funding') {
			return $this->hasMany('App\Models\Ticket')->orderBy('price', 'asc');
		} else {
			return $this->hasMany('App\Models\Ticket')->orderBy('delivery_date', 'asc');
		}
	}

	public function orders() {
		return $this->hasMany('App\Models\Order');
	}

	public function supporters() {
		return $this->hasMany('App\Models\Supporter')->orderBy('created_at', 'desc');
	}
	
	public function comments() {
		return $this->morphMany('App\Models\Comment', 'commentable')->orderBy('created_at', 'desc');
	}
	
	public function news() {
		return $this->hasMany('App\Models\News')->orderBy('created_at', 'desc');
	}

	public function isFinished() {
		if ($this->funding_closing_at) {
			return strtotime($this->funding_closing_at) - time() < 0;
		}
		return true;
	}
	
	public function isBuyable() {
		return !$this->isFinished() && (int) $this->state === 4;
	}
	
	public function dayUntilFundingClosed() {
		$diff = max(strtotime($this->funding_closing_at) - time(), 0);
		$secondsInDay = 60 * 60 * 24;
		return floor($diff / $secondsInDay);
	}
	
	public function getPosterUrl() {
		if ($this->poster_url) {
			return $this->poster_url;
		}
		return "http://immortaldc.com/wp-content/themes/sentient/img/no_image.png";
	}
	
	public function getProgress() {
		if ($this->pledged_amount > 0) {
			return (int) (($this->funded_amount / $this->pledged_amount) * 100);
		}
		return 0;
	}
	
	public function getTicketDateFormatted() {
		$open = new \DateTime('now');
		$close = new \DateTime('now');
		if ($this->performance_opening_at) {
			$open = new \DateTime($this->performance_opening_at);
		}
		if ($this->performance_closing_at) {
			$close = new \DateTime($this->performance_closing_at);
		}
		$open = $open->format('Y. m. d');
		$close = $close->format('Y. m. d');
		if ($open === $close) {
			return $open;
		}
		return  $open. ' ~ ' . $close;
	}

	public function getFundingClosingAtOrNow() {
		$time = time();
		if ($this->funding_closing_at) {
			$time = strtotime($this->funding_closing_at);
		}
		return date('Y-m-d', $time);
	}
	
	public function isReady() {
		return (int) $this->state === Project::STATE_READY || (int) $this->state === Project::STATE_READY_AFTER_FUNDING;
	}
	
	public function isUnderConstruction() {
		return (int) $this->state === Project::STATE_UNDER_INVESTIGATION;
	}
	
	public function isPublic() {
		return (int) $this->state === Project::STATE_APPROVED;
	}
	
	public function isSuccess() {
		return $this->funded_amount >= $this->pledged_amount;
	}
	
	public function getValidYouTubeUrl() {
		$path = parse_url($this->video_url, PHP_URL_PATH);
		$pathFragments = explode('/', $path);
		$end = end($pathFragments);
		return "https://youtube.com/v/" . $end;
	}
	
	public function countSessionDependentViewNum() {
		$projectIds = session('project_ids');
		if (is_array($projectIds) && in_array($this->id, $projectIds)) {
			return;
		}
		$this->increment('view_count');
		session()->push('project_ids', $this->id);
	}

}
