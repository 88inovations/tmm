<select class="_student_id form-control  select2" name="_student_id">
    <option value="">Select Student</option>
    @forelse($students as $student)
    <option value="{{$student->id}}">{!! $student->_name_in_bangla ?? '' !!}  |{!! $student->_name_in_english ?? '' !!}  | {!! $student->_student_id ?? '' !!} | {!! $student->_father_name_english ?? '' !!}</option>
    @empty
    @endforelse
</select>


<script type="text/javascript">
     $(document).find('.select2').select2()
</script>