<?php

namespace App\Policies;

use App\User;
use App\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

	/**
	 * @param User $user
	 * @return bool
	 */
	public function index(User $user){
		return true;
	}

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
	{
		if($user->hasPermission('ticket')){
			return true;
		}
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}elseif(!empty($ticket->user) && ($user->id === $ticket->user->id)){
			//user can see his/her ticket
			return true;
    	}

		//department leader and staff can see the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->departments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition>0){
			return true;
		}

        return false;
    }

    /**
     * Determine whether the user can create tickets.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    	return true;
    }

    /**
     * Determine whether the user can update the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
		if($user->hasPermission('ticket')){
			return true;
		}
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}elseif(!empty($ticket->user) && ($user->id === $ticket->user->id)){
			//user can see his/her ticket
			return true;
    	}

		//department leader and staff can see the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->departments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition){
			return true;
		}

        return false;
    }

    /**
     * Determine whether the user can close the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function close(User $user,Ticket $ticket){
		if($user->hasPermission('ticket')){
			return true;
		}
		if($user->owner() || $user->admin()){
			//admin and owner user can close all tickets
			return true;
		}
		//leader can close the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->leaderInDepartments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition){
			return true;
		}

		//staff can close the tickets belongs to their department and configs set.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->staffInDepartments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition && config('staff.closeTicket.status')){
			return true;
		}

		if(!empty($ticket->user) && ($user->id === $ticket->user->id) && config('user.closeTicket.status')){
			//user can close his/her ticket
			return true;
    	}

        return false;
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
		if($user->hasPermission('ticket')){
			return true;
		}
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}
		//users (except owner and admin) can delete branch tickets if its config is enabled
		if(!$ticket->isRoot() && !config('ticket.remove.status')){
			return false;
		}

		//leader can remove the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->leaderInDepartments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition){
			return true;
		}

		//staff can remove the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->staffInDepartments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition && config('staff.removeTicket.status')){
			return true;
		}

		if(!empty($ticket->user) && ($user->id === $ticket->user->id) && config('user.removeTicket.status')){
			//user can remove his/her ticket
			return true;
    	}

        return false;
    }

	/**
	 * garbage list
	 *
	 * @param User $user
	 * @return bool
	 */
    public function garbage(User $user){
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}
    }

	/**
	 * remove ticket permanently
	 *
	 * @param User $user
	 * @param Ticket $ticket
	 * @return bool
	 */
	public function permanentDelete(User $user, Ticket $ticket){
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}
	}

	/**
	 * recycle removed tickets
	 *
	 * @param User $user
	 * @param Ticket $ticket
	 * @return bool
	 */
	public function recycle(User $user,Ticket $ticket){
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}
	}

    /**
     * Determine whether the user can update the ticket's department.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function departmentUpdate(User $user, Ticket $ticket){
		if($user->hasPermission('ticket')){
			return true;
		}
		if($user->owner() || $user->admin()){
			//admin and owner user can see all tickets
			return true;
		}
		if(!empty($ticket->user) && ($user->id === $ticket->user->id) && config('ticket.department.substitution.status')){
			//user can see his/her ticket
			return true;
    	}
		//department leader and staff can see the tickets belongs to their department.
		$condition=Ticket::where('id','=',$ticket->id)
			  			 ->whereNull('ticket_id')
			  			 ->whereHas('department',function($query) use ($user){
							$departments=$user->departments()->pluck('department_id')->toArray();
							$query->whereIn('department_id',$departments);
						 })->count();
		if($condition){
			return true;
		}

        return false;
    }

    /**
     * Determine whether the user can rate the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function rateStore(User $user, Ticket $ticket){
		if(!config('ticket.rating.status')){//rating tickets is not active
			return false;
		}

		if(!$ticket->user){ //guest ticket
			return false;
		}

		if($ticket->user->id==$user->id){//user cant rate his/her self ticket
			return false;
		}

		//creator of the root (main) ticket can rate branch tickets
		if($user->id!=$ticket->root()->id){
			return false;
		}

		// owner or admin or department users( staff or leader) replies can be rated.
		if(
			$ticket->user->owner() ||
			$ticket->user->admin() ||
			$ticket->user->departments()->count()>0
		){
			return true;
		}
		return false;
    }
}
