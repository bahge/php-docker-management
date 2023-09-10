<?php

declare(strict_types=1);

namespace Bahge\Dkman\Shared\Constants;

final class AppError
{
    public static string $FILE_NOT_FOUND = "Arquivo yaml não encontrado.";
    public static string $IMAGE_NOT_FOUND = "Nenhuma imagem encontrada no yaml.";
    public static string $HEADER_NOT_VALID = "A versão do yaml não permitida.";
    public static string $IMAGE_NOT_VALID = "Nenhum serviço válido encontrado no yaml";
    public static string $CLI_IS_NOT_VALID = "Erro na chamada, verifique a sintaxe e reenvie o comando";
}
