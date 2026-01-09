<form method="POST" action="/mypage/profile">
  @csrf

  <div>
    <label>ユーザー名</label>
    <input type="text" name="username" value="{{ old('username', $user->username) }}">
  </div>

  <div>
    <label>郵便番号</label>
    <input type="text" name="postcode" value="{{ old('postcode', $user->postcode) }}">
  </div>

  <div>
    <label>住所</label>
    <input type="text" name="address" value="{{ old('address', $user->address) }}">
  </div>

  <div>
    <label>建物名</label>
    <input type="text" name="building" value="{{ old('building', $user->building) }}">
  </div>

  <button type="submit">更新する</button>
</form>
