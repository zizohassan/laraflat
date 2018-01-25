<div class="footer-basic">
    <footer>
        <div class="social">
            <a href="https://twitter.com/5dmat_web"><i class="fa fa-twitter"></i></a>
            <a href="https://www.facebook.com/5damatWeb/"><i class="fa fa-facebook"></i></a>
            <a href="https://www.linkedin.com/in/abdel-aziz-hassan-844513105/"><i class="fa fa-linkedin"></i></a>
            <a href="https://www.youtube.com/channel/UCf3uCfBXTG4YtBrKxpejOJg"><i class="fa fa-youtube"></i></a>
        </div>
        @php $pages = page(); @endphp
        <ul class="list-inline">
            @foreach($pages as $page)
                <li><a href="{{ url('page/'.$page->id.'/view') }}">{{ getDefaultValueKey($page->title) }}</a></li>
            @endforeach
            <li><a href="{{ url('contact') }}">{{ trans('website.Contact Us') }}</a></li>
        </ul>
        <p class="copyright">{{ getSetting('siteTitle') }} © 2016</p>
    </footer>
</div>