<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    // 📌 Авторизация пользователя и генерация токена
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['access_token' => $token]);
    }

    // 📌 Регистрация нового пользователя
    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function changePassword(Request $request)
    {   
        try {
            // Получаем текущего пользователя
            $user = JWTAuth::parseToken()->authenticate();

            if (!$user) {
                return response()->json(['error' => 'Пользователь не найден'], 404);
            }

            // Проверяем старый пароль
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'Текущий пароль неверен'], 400);
            }

            // Меняем пароль
            $user->password = Hash::make($request->new_password);
            $user->save();

            return response()->json(['message' => 'Пароль успешно изменен!']);
        
        } catch (JWTException $e) {
            return response()->json(['error' => 'Ошибка авторизации'], 401);
        }
    }

    // 📌 Получение информации о пользователе по токену
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate(); // или Auth::user()
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
    
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token is invalid or expired'], 401);
        }
    
        // Логируем запрос для проверки
        \Log::info('Update request data', $request->all());
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
    
        $user->update($request->only('name', 'email'));
    
        return response()->json(['message' => 'Профиль обновлен!', 'user' => $user]);
    }
    
    

    // 📌 Выход (аннулирование токена)
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    // 📌 Обновление токена
    public function refresh(Request $request)
    {
        $refreshToken = $request->input('refresh_token');
        
        // Если нет refresh токена, вернуть ошибку
        if (!$refreshToken) {
            return response()->json(['error' => 'Refresh token is required'], 400);
        }

        try {
            // Обновляем access токен с помощью refresh токена
            $newToken = JWTAuth::refresh($refreshToken);

            return response()->json(['access_token' => $newToken]);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to refresh token'], 500);
        }
    }
}
