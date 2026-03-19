<div class="flex items-center gap-3">
  <x-wire-button href="{{ route('admin.users.edit', $users) }}" blue xs>
    <i class="fa-solid fa-pen-to-square"></i>
  </x-wire-button>

  <form action="{{ route('admin.users.destroy', $users) }}" method="post" class="delete-form">
      @csrf
      @method('DELETE')
      <x-wire-button type="submit" red xs>
        <i class="fa-solid fa-trash"></i>
      </x-wire-button>
  </form>
</div>