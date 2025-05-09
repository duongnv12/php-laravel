@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Chương trình đào tạo') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-2xl font-bold mb-4">{{ $program->name }}</h3>
        <p class="mb-2"><strong>Mô tả:</strong> {{ $program->description }}</p>
        <div class="mb-4">
            <strong>Danh sách Môn học:</strong>
            @if($program->courses->count())
                <ul class="list-disc ml-4">
                    @foreach($program->courses as $course)
                        <li>{{ $course->code }} - {{ $course->name }}</li>
                    @endforeach
                </ul>
            @else
                <em>Chưa có môn học</em>
            @endif
        </div>
        <div class="mt-4">
            <a href="{{ route('programs.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Trở lại danh sách</a>
            <a href="{{ route('programs.edit', $program->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded ml-2">Chỉnh sửa</a>
        </div>
    </div>
</div>
@endsection
