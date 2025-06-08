<?php

namespace App\Livewire\Sites;

use App\Models\Page;
use App\Models\Subdomain;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class EditPage extends Component
{
    use Toast;
    use WithFileUploads;

    public Subdomain $subdomain;

    #[Validate('required|string|min:2|max:100')]
    public $name;
    #[Validate('required|min:2|max:100')]
    public $domain;

    #[Validate("string")]
    public $codigo;

    #[Validate('nullable|image|max:2048')]
    public $file_image;

    #[Validate("string|required")]
    public $description;

    public function mount(Subdomain $subdomain)
    {
        $this->subdomain = $subdomain;

        $this->name = $subdomain->name;

        $this->domain = $subdomain->domain;

        $this->codigo = $subdomain->codigo;

        $this->description = $subdomain->description;
    }


    #[On('page-created')]
    public function onPageCreated()
    {
        $this->subdomain->refresh();
    }

    public function save()
    {

        // Upload da imagem principal
        if ($this->file_image instanceof \Illuminate\Http\UploadedFile) {
            // Remove a imagem antiga, se existir
            if ($this->subdomain->image) {
                Storage::disk('public')->delete($this->subdomain->image);
            }
            $image = $this->file_image->store('images', 'public');

            $this->subdomain->image = $image;
            $this->subdomain->save();
        }


        $this->subdomain->update([
            'name' => $this->name,
            'domain' => $this->domain,
            'codigo' => $this->codigo,
            'description' => $this->description,
        ]);


        $this->success('Página atualizada com sucesso!');
    }

    public function deletePage($pageId)
    {
        Page::findOrFail($pageId)->delete();
    }

    public function render()
    {
        return view('livewire.sites.edit-page');
    }
}
