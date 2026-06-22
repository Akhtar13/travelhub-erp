<form method="post" action="{{ route('password.email') }}">@csrf <h1>Forgot Password</h1><input name="email" type="email" required><button>Send reset link</button></form>
