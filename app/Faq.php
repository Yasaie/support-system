<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Mews\Purifier\Facades\Purifier;

class Faq extends Model
{
	protected $table='faqs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=['question','answer'];

	/**
	 * clean question (html) before saving.
	 *
	 * @param $question
	 */
    public function setQuestionAttribute($question){
		$this->attributes['question'] = Purifier::clean($question);
    }

	/**
	 * clean answer (html) before saving.
	 *
	 * @param $answer
	 */
    public function setAnswerAttribute($answer){
		$this->attributes['answer'] = Purifier::clean($answer);
    }

}
