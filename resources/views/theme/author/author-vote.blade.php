@php
    $user_vote = $user->getVoteCount();

    if(auth()->check())
      $disabled = auth()->user()->checkVote($user->id)?'disabled':'';
    else
      $disabled = 'disabled';
@endphp
<div class="d-flex align-items-center ">
  <ul class="ratings {{ $disabled??'' }}" data-id="{{ $user->id }}">
  <li class="star {{ $user_vote == 5 ? 'selected' : '' }}" title="5" ></li>
  <li class="star {{ $user_vote >= 4 ? 'selected' : '' }}" title="4"></li>
  <li class="star {{ $user_vote >= 3 ? 'selected' : '' }}" title="3"></li>
  <li class="star {{ $user_vote >= 2 ? 'selected' : '' }}" title="2"></li>
  <li class="star {{ $user_vote >= 1 ? 'selected' : '' }}" title="1"></li>
</ul>
<span style="white-space: nowrap; font-size: 13px">({{ $user->getVote()->count() }} vote)</span>
</div>