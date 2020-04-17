<!-- ============ Customizer ============= -->
<div class="customizer">
    <div class="handle" (click)="isOpen = !isOpen">
        <i class="i-Gear spin"></i>
    </div>
    <div class="customizer-body" data-perfect-scrollbar data-suppress-scroll-x="true">
        <div class="accordion" id="accordionCustomizer">

<div class="card">
    <div class="card-header" id="headingTwo">
        <p class="mb-0">
            RTL
        </p>
    </div>

    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionCustomizer">
        <div class="card-body">
            <label class="checkbox checkbox-primary">
                <input type="checkbox" id="rtl-checkbox">
                <span>Habilitar RTL</span>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
</div>

{{-- dark mode --}}
<div class="card">
    <div class="card-header" id="headingTwo">
        <p class="mb-0">
            Version oscuro
        </p>
    </div>

    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionCustomizer">
        <div class="card-body">
            <label class="checkbox checkbox-primary">
                <input type="checkbox" id="dark-checkbox">
                <span>Habilitar modo oscuro</span>
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
</div>

</div>
</div>
</div>
<!-- ============ End Customizer ============= -->