<p class="lead">
    {!! icon('check') !!} MemberReserve
</p>
<ul class="list-unstyled">
    <ul>

        @forelse($sidemenus as $sidemenu)
            <li class="">
                <a href="{{ route('member.reserve', ['hallid' => $sidemenu->id])}}">{{$sidemenu->hallname}} Status
                </a>
            </li>
        @empty
        @endforelse
    </ul>

</ul>

<p class="lead">
    {!! icon('check') !!} ReserveList
</p>
<ul class="list-unstyled">
    <ul>
        @forelse($sidemenus as $sidemenu)
            <li class="">
                <a href="{{ route('member.reservelist',["hallid" => $sidemenu->id])}}">{{$sidemenu->hallname}} Reserve Status
                </a>
            </li>
        @empty

        @endforelse
    </ul>
</ul>

