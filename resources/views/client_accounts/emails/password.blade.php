Click here to reset your password: <a href="{{ $link = url('client/password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
