@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Chi tiết Niên khóa') }}
    </h2>
@endsection

@section('content')
<div class="container mx-auto py-8">
   <div class="bg-white p-6 rounded shadow-md">
        <h3 class="text-2xl font-bold mb-4">{{ $cohort->name }}</h3>
        <p class="mb-2"><strong>Năm bắt đầu:</strong> {{ $cohort->start_year }}</p>
        <p class="mb-2"><strong>Năm kết thúc:</strong> {{ $cohort->end_year }}</p>
        <div class="mb-4">
            <strong>Chương trình đào tạo:</strong>
            @if($cohort->programs->count())
                <ul class="list-disc ml-4">
                    @foreach($cohort->programs as $program)
                        <li>{{ $program->name }}</li>
                    @endforeach
                </ul>
            @else
                <em>Chưa có chương trình</em>
            @endif
        </div>
        <div class="mt-4">
            <a href="{{ route('cohorts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Trở lại danh sách</a>
            <a href="{{ route('cohorts.edit', $cohort->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded ml-2">Chỉnh sửa</a>
        </div>
   </div>
</div>
@endsection
