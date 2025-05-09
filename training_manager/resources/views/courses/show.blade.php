@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Môn học') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
    <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-2xl font-bold mb-4">{{ $course->code }} - {{ $course->name }}</h3>
        <p class="mb-2"><strong>Số tín chỉ:</strong> {{ $course->credit }}</p>
        <p class="mb-2"><strong>Mô tả:</strong> {{ $course->description }}</p>
        <div class="mb-4">
            <strong>Môn tiên quyết:</strong>
            @if($course->prerequisites->count())
                <ul class="list-disc ml-4">
                    @foreach($course->prerequisites as $prerequisite)
                        <li>{{ $prerequisite->code }} - {{ $prerequisite->name }}</li>
                    @endforeach
                </ul>
            @else
                <em>Không có</em>
            @endif
        </div>
        <div class="mt-4">
            <a href="{{ route('courses.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Trở lại danh sách</a>
            <a href="{{ route('courses.edit', $course->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded ml-2">Chỉnh sửa</a>
        </div>
    </div>
</div>
@endsection
