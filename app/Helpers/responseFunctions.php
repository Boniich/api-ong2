<?php

function successResponse(object $data, string $message)
{
    return ['success' => true, 'data' => $data, 'message' => $message];
}


function errorResponse(string $message)
{
    return ['success' => false, 'error' => $message];
}

function okResponse200($data, string $message)
{

    return response()->json(successResponse($data, $message));
}

function resourceCreatedResponse201($data, string $message)
{

    return response()->json(successResponse($data, $message), 201);
}

function badRequestResponse400()
{
    return response()->json(errorResponse('Bad Request'), 400);
}

function modelNotFoundResponse(string $message)
{
    return response()->json(errorResponse($message), 404);
}
