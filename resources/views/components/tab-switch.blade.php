<div class="tabs">
    <button class="tab-btn" data-tab="desc">Deskripsi</button>
    <button class="tab-btn" data-tab="update">Update</button>
</div>

<div class="tab-content" id="tab-desc">
    @yield('tab_desc')
</div>

<div class="tab-content" id="tab-update" style="display:none">
    @yield('tab_update')
</div>

<script>
document.querySelectorAll(".tab-btn").forEach(btn => {
    btn.onclick = () => {
        document.querySelectorAll(".tab-content").forEach(el => el.style.display="none");
        document.querySelector("#tab-" + btn.dataset.tab).style.display="block";
    }
});
</script>
