<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductControllerTest extends TestCase
{
    protected ProductController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ProductController();
    }

    // ==================== INDEX TESTS ====================

    /** @test */
    public function index_geeft_gepagineerde_producten_terug()
    {
        // Arrange
        $fakeProducten = [
            (object)['ProductId' => 1, 'ProductNaam' => 'Cola Flesjes'],
            (object)['ProductId' => 2, 'ProductNaam' => 'Drop Munten'],
        ];

        DB::shouldReceive('select')
            ->once()
            ->with('CALL pakAlleProducten(?, ?)', [4, 0])
            ->andReturn($fakeProducten);

        DB::shouldReceive('table')
            ->with('Product')
            ->andReturnSelf();

        DB::shouldReceive('count')
            ->andReturn(17);

        $request = Request::create('/producten', 'GET', ['page' => 1]);

        // Act
        $response = $this->controller->index($request);

        // Assert
        $viewData = $response->getData();

        $this->assertEquals('Overzicht producten', $viewData['titel']);
        $this->assertCount(2, $viewData['producten']);
        $this->assertEquals(17, $viewData['producten']->total());
        $this->assertEquals(1, $viewData['producten']->currentPage());
    }

    /** @test */
    public function index_gebruikt_correcte_offset_op_pagina_twee()
    {
        // Arrange - pagina 2 → offset moet 4 zijn
        $fakeProducten = [
            (object)['ProductId' => 5, 'ProductNaam' => 'Kruis Drop'],
        ];

        DB::shouldReceive('select')
            ->once()
            ->with('CALL pakAlleProducten(?, ?)', [4, 4])
            ->andReturn($fakeProducten);

        DB::shouldReceive('table')->with('Product')->andReturnSelf();
        DB::shouldReceive('count')->andReturn(17);

        $request = Request::create('/producten', 'GET', ['page' => 2]);

        // Act
        $response = $this->controller->index($request);

        // Assert
        $viewData = $response->getData();
        $this->assertEquals(2, $viewData['producten']->currentPage());
    }

    // ==================== SPECIFIEK TESTS ====================

    /** @test */
    public function specifiek_geeft_productinfo_terug_zonder_datumfilter()
    {
        // Arrange - geen datums → pakProductBijId wordt NIET aangeroepen
        $fakeProductInfo = [
            (object)[
                'ProductId'   => 1,
                'ProductNaam' => 'Cola Flesjes',
                'Barcode'     => '8719587321237',
            ]
        ];

        DB::shouldReceive('select')
            ->once()
            ->with('CALL pakProductInfo(?)', [1])
            ->andReturn($fakeProductInfo);

        // pakProductBijId mag niet worden aangeroepen
        DB::shouldNotReceive('select')
            ->with('CALL pakProductBijId(?, ?, ?)', \Mockery::any());

        $request = Request::create('/producten/1', 'GET'); // geen datums

        // Act
        $response = $this->controller->Specifiek($request, 1);

        // Assert
        $viewData = $response->getData();

        $this->assertEquals('Specificatie geleverde producten', $viewData['titel']);
        $this->assertEquals(1, $viewData['productId']);
        $this->assertNull($viewData['resultaten']);
    }

    /** @test */
    public function specifiek_geeft_gefilterde_resultaten_bij_datumfilter()
    {
        // Arrange
        $fakeProductInfo = [
            (object)['ProductId' => 1, 'ProductNaam' => 'Cola Flesjes'],
        ];

        $fakeLeveringen = [
            (object)['LeverancierNaam' => 'Astra Sweets', 'DatumLevering' => '2023-04-14'],
            (object)['LeverancierNaam' => 'De Bron',      'DatumLevering' => '2023-04-18'],
        ];

        // pakProductInfo wordt eerst aangeroepen
        DB::shouldReceive('select')
            ->once()
            ->with('CALL pakProductInfo(?)', [1])
            ->andReturn($fakeProductInfo);

        // daarna pakProductBijId met de datums
        DB::shouldReceive('select')
            ->once()
            ->with('CALL pakProductBijId(?, ?, ?)', [1, '2023-04-01', '2023-04-30'])
            ->andReturn($fakeLeveringen);

        $request = Request::create('/producten/1', 'GET', [
            'startDatum' => '2023-04-01',
            'eindDatum'  => '2023-04-30',
        ]);

        // Act
        $response = $this->controller->Specifiek($request, 1);

        // Assert
        $viewData = $response->getData();

        $this->assertNotNull($viewData['resultaten']);
        $this->assertCount(2, $viewData['resultaten']);
        $this->assertEquals('Astra Sweets', $viewData['resultaten'][0]->LeverancierNaam);
    }
}