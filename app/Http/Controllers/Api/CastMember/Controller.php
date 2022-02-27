<?php

namespace App\Http\Controllers\Api\CastMember;

use App\Factories\AbstractFactory;
use App\Factories\CastMemberDTOFactory;
use App\Http\Controllers\AbstractController;
use App\Services\CastMember\CreateCastMemberService;
use App\Services\CastMember\GetAllCastMemberService;
use App\Services\CastMember\GetOneCastMemberService;
use App\Services\CastMember\RemoveCastMemberService;
use App\Services\CastMember\UpdateCastMemberService;
use JetBrains\PhpStorm\Pure;

class Controller extends AbstractController
{
    #[Pure]
    public function __construct(
        GetAllCastMemberService $indexService,
        GetOneCastMemberService $showService,
        CreateCastMemberService $createService,
        UpdateCastMemberService $updateService,
        RemoveCastMemberService $deleteService,
        CastMemberDTOFactory $castMemberDTOFactory,
    ) {
        $rules = [
            'name' => 'required|string|max:255',
            'type' => 'numeric|min:1|max:2',
        ];
        parent::__construct(
            indexService:   $indexService,
            showService:    $showService,
            createService:  $createService,
            updateService:  $updateService,
            deleteService:  $deleteService,
            abstractFactory: $castMemberDTOFactory,
            rules: $rules,
        );
    }
}
