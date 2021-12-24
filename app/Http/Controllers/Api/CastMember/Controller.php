<?php

namespace App\Http\Controllers\Api\CastMember;

use App\DTO\CastMemberDTO;
use App\Factories\CastMemberDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\CastMember\CreateCastMemberService;
use App\Services\CastMember\GetAllCastMemberService;
use App\Services\CastMember\GetOneCastMemberService;
use App\Services\CastMember\RemoveCastMemberService;
use App\Services\CastMember\UpdateCastMemberService;
use JetBrains\PhpStorm\ArrayShape;

class Controller extends AbstractController
{
    public function __construct(
        GetAllCastMemberService $indexService,
        GetOneCastMemberService $showService,
        CreateCastMemberService $createService,
        UpdateCastMemberService $updateService,
        RemoveCastMemberService $deleteService,
    ) {
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
        );
    }

    public function factoryDTO(array $data): CastMemberDTO
    {
        return CastMemberDTOFactory::make($data);
    }

    #[ArrayShape(['name' => "string", 'type' => "string"])]
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'type' => 'numeric|min:1|max:2',
        ];
    }
}
