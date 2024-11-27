
<div>
    @if($openModal)
    <div class="dialog dialog-sm">
        <div class="dialog-content">
            <div class="dialog-header">Confirmar Acción
                <button type="button" class="btn btn-light btn-sm btn-icon" aria-label="Close" wire:click="hideModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
            </div>
            <div class="dialog-body"><p>¿Estás seguro que deseas (Habilitar/Desabilitar) este usuario?</p></div>
            <div class="dialog-footer">
                <button type="button" class="btn btn-light" wire:click="hideModal">Cancelar</button>
                <button type="button" class="btn btn-primary" wire:click="confirmDeleteUser">Aceptar</button>
            </div>
        </div>
    </div>
    @endif
</div>
