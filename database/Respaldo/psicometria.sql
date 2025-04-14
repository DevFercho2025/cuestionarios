-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-04-2025 a las 16:02:14
-- Versión del servidor: 9.1.0
-- Versión de PHP: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `psicometria`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_aplicaciones`
--

DROP TABLE IF EXISTS `psico_alobri_aplicaciones`;
CREATE TABLE IF NOT EXISTS `psico_alobri_aplicaciones` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `vacante` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_aplicaciones`
--

INSERT INTO `psico_alobri_aplicaciones` (`id`, `user_id`, `vacante`, `codigo`) VALUES
(3, 36, 'A', 'UK63PDHHOK'),
(6, 37, 'D', 'QDLWOETLEP');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_categorias`
--

DROP TABLE IF EXISTS `psico_alobri_categorias`;
CREATE TABLE IF NOT EXISTS `psico_alobri_categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo_cuestionario` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `time_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_categorias`
--

INSERT INTO `psico_alobri_categorias` (`id`, `titulo_cuestionario`, `created_at`, `updated_at`, `time_at`) VALUES
(1, 'Prueba de Integridad de Reid (Reid Integrity Test)', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(2, 'Inventario de Honestidad de O\'\'connor', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(3, 'All port', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(4, 'Barsit', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(5, 'Cleaver', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(6, 'Gordon', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(7, 'Inglés', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(8, 'IPV', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(9, 'Kostick', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(10, 'LIFO', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(11, 'Moss', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(12, 'Raven', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(13, 'Terman', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(14, 'Wonderlic', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(15, 'Zavik', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00'),
(16, '16PF', '2025-04-10 16:39:52', '2025-04-10 16:39:52', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_companies`
--

DROP TABLE IF EXISTS `psico_alobri_companies`;
CREATE TABLE IF NOT EXISTS `psico_alobri_companies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_companies`
--

INSERT INTO `psico_alobri_companies` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Compañía ejemplo', '2025-04-10 17:32:22', '2025-04-10 17:32:22'),
(2, 'Compañía segunda', '2025-04-11 17:32:26', '2025-04-11 17:32:26');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_imagenes_usuario`
--

DROP TABLE IF EXISTS `psico_alobri_imagenes_usuario`;
CREATE TABLE IF NOT EXISTS `psico_alobri_imagenes_usuario` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL,
  `token_id` bigint UNSIGNED DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `token_id` (`token_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_imagenes_usuario`
--

INSERT INTO `psico_alobri_imagenes_usuario` (`id`, `id_usuario`, `file_name`, `file_path`, `created_at`, `token_id`) VALUES
(9, 12, '67f567f850e06.png', 'private/uploads/67f567f850e06.png', '2025-04-09 00:16:24', 2),
(10, 12, '67f568014c1e7.png', 'private/uploads/67f568014c1e7.png', '2025-04-09 00:16:33', 2),
(11, 12, '67f5680bbe7f5.png', 'private/uploads/67f5680bbe7f5.png', '2025-04-09 00:16:43', 2),
(12, 18, '67f57744dbad9.png', 'private/uploads/67f57744dbad9.png', '2025-04-09 01:21:40', NULL),
(13, 18, '67f5774dd24f2.png', 'private/uploads/67f5774dd24f2.png', '2025-04-09 01:21:49', NULL),
(14, 18, '67f57756d8f45.png', 'private/uploads/67f57756d8f45.png', '2025-04-09 01:21:58', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_preguntas`
--

DROP TABLE IF EXISTS `psico_alobri_preguntas`;
CREATE TABLE IF NOT EXISTS `psico_alobri_preguntas` (
  `pregunta_id` int NOT NULL,
  `pregunta` varchar(200) NOT NULL,
  `cuestionario` varchar(200) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `seccion_id` int NOT NULL,
  PRIMARY KEY (`pregunta_id`),
  KEY `seccion_id` (`seccion_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_preguntas`
--

INSERT INTO `psico_alobri_preguntas` (`pregunta_id`, `pregunta`, `cuestionario`, `required`, `seccion_id`) VALUES
(1, 'Si accidentalmente encuentras un sobre con dinero en la oficina, ¿Qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 1),
(2, '¿Alguna vez has mentido para evitar recibir una reprimenda en el trabajo?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 1),
(3, 'Si te encuentras con un error en tu trabajo que no puede ser fácilmente detectado por otros, ¿lo corregirías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 1),
(4, 'Si un compañero no está cumpliendo con sus responsabilidades y tú sabes que esto afecta al equipo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 1),
(5, '¿Alguna vez has falsificado un documento para cumplir con un objetivo laboral?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(6, 'Si un cliente te pide que omitas información importante sobre un producto, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(7, '¿Has llegado alguna vez tarde al trabajo sin justificarlo correctamente?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(8, 'Si un compañero te pide que cubras su error, ¿lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(9, '¿Alguna vez has utilizado tiempo laboral para hacer tareas personales?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(10, 'Si encuentras información confidencial de un compañero en su escritorio, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(11, 'Si un compañero te pide que hagas algo que sabes que no está permitido, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(12, '¿Alguna vez has tomado algo de la oficina sin permiso?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(13, 'Si un cliente te hace un regalo, ¿lo aceptarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(14, 'Si un compañero no está cumpliendo con los plazos de entrega, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(15, 'Si sabes que un compañero está violando las normas de la empresa, ¿lo denunciarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(16, 'Si descubres que un compañero de trabajo está utilizando información confidencial de la empresa de manera inapropiada, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(17, 'Si tu jefe te pide que no menciones un problema a otros empleados, ¿lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(18, '¿Has alguna vez omitido información importante en un informe para hacerlo parecer mejor de lo que realmente es?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(19, '¿Te ha sucedido que has dado una respuesta falsa para evitar un conflicto?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(20, 'Si un compañero está recibiendo un crédito que tú crees que te corresponde, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(21, 'Si un supervisor te pide que cubras su error, ¿lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(22, '¿Alguna vez has hecho algo que sabías que estaba mal, pero lo hiciste de todas formas?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(23, 'Si encuentras un objeto perdido en el lugar de trabajo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(24, 'Si un compañero te pide que cubras una falta de su parte, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(25, 'Si un cliente se queja de un servicio que tú no prestaste, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(26, 'Si un supervisor te pide que realices una tarea que sabes que es inapropiada, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(27, '¿Te has quedado alguna vez con materiales de oficina para uso personal?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(28, 'Si un compañero de trabajo te pide que lo cubras en una mentira, ¿lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(29, 'Si sabes que una persona está faltando a la verdad en una reunión importante, ¿lo señalarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(30, 'Si un cliente te pide un trato especial, aunque sepas que no es posible, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(31, '¿Te ha pasado alguna vez que alguien te ha pedido hacer algo ilegal o inmoral en el trabajo?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(32, 'Si te ofrecen un soborno para favorecer a un cliente, ¿lo aceptarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(33, '¿Alguna vez has utilizado un recurso de la empresa para beneficio personal?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(34, 'Si un compañero no está haciendo su parte en un proyecto, ¿cómo actuarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(35, 'Si un cliente te pide que mientas sobre un producto o servicio, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 1),
(36, 'Si te das cuenta de que has cometido un error en un proyecto, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 2),
(37, 'Si un compañero te pide ayuda con algo que no te corresponde, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(38, 'Si tu jefe te da una orden que no estás de acuerdo con ella, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(39, 'Si un compañero de trabajo está involucrado en un comportamiento poco ético, ¿lo denunciarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(40, 'Si te das cuenta de que un cliente está siendo engañado, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(41, 'Si un colega te ofrece información confidencial sin que se te haya pedido, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(42, 'Si un cliente te hace una solicitud que sabes que va en contra de las políticas de la empresa, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(43, 'Si un compañero te ofrece una oportunidad de trabajo que sabes que podría causar conflicto de intereses, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(44, '¿Alguna vez has utilizado información de la empresa para beneficiarte personalmente?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(45, 'Si alguien te pide que tomes una decisión que podría perjudicar la reputación de la empresa, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(46, 'Si un cliente te ofrece un trato especial a cambio de favores, ¿lo aceptarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(47, 'Si un compañero no cumple con su parte en un proyecto, ¿lo asumirías como propio para que no afecte a la empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(48, '¿Has tomado alguna vez una decisión basada en intereses personales, aunque eso fuera en detrimento de la empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(49, 'Si sabes que un colega está siendo injusto con un cliente o compañero, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(50, '¿Aceptarías un trabajo si sabes que la empresa está involucrada en prácticas poco éticas?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(51, 'Si descubres que un compañero ha cometido fraude, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(52, 'Si un cliente te pide que realices una acción que no es legal, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(53, 'Si un colega se beneficia de algo que no le corresponde, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(54, 'Si un compañero se aprovecha de un error que cometiste para su propio beneficio, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(55, 'Si un compañero te pide que realices una tarea que no es parte de tus responsabilidades, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(56, 'Si un cliente te proporciona información falsa, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(57, 'Si un compañero de trabajo te pide que le ayudes a cubrir una falta en su desempeño, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(58, 'Si te ofrecen un incentivo para hacer algo que sabes que no es ético, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(59, 'Si descubres que un compañero está robando recursos de la empresa, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(60, '¿Aceptarías un soborno para favorecer a un cliente?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(61, 'Si un compañero de trabajo comete un error que perjudica a un cliente, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(62, '¿Es aceptable ocultar información importante a un cliente si se considera beneficioso para la empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(63, 'Si tu jefe te pide que manipules datos para hacer que un informe se vea mejor, ¿lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(64, 'Si te das cuenta de que alguien está violando una política interna importante, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(65, 'Si un compañero te invita a participar en una actividad fuera del trabajo que sabes que puede ser inapropiada, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(66, 'Si te das cuenta de que alguien está manipulando información para su propio beneficio, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(67, 'Si descubres que un cliente está haciendo fraude, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(68, 'Si un compañero te pide que lo cubras por un error que él cometió, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(69, 'Si te das cuenta de que un proceso de la empresa no es completamente transparente, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(70, 'Si se te ofrece un acceso a un sistema confidencial que no corresponde a tu trabajo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 2),
(71, 'Si te enfrentas a un problema en el trabajo, ¿cómo lo abordarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 3),
(72, 'Si un colega te presenta una solución a un problema que no consideras viable, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(73, 'Si te enfrentas a un dilema ético en el trabajo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(74, 'Si un proyecto no está avanzando según lo planeado, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(75, 'Si tienes que tomar una decisión importante pero no tienes toda la información necesaria, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(76, 'Si un miembro del equipo no está cumpliendo con sus responsabilidades, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(77, 'Si un problema en el trabajo está afectando la moral del equipo, ¿cómo actuarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(78, 'Si te enfrentas a un conflicto de intereses, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(79, 'Si un cliente te hace una solicitud que podría generar problemas a largo plazo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(80, 'Si descubres que un proyecto tiene errores en la planificación, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(81, 'Si un proyecto tiene múltiples soluciones posibles, ¿cómo decidirías cuál es la mejor?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(82, 'Si un compañero te presenta una solución que podría perjudicar a otros, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(83, 'Si te enfrentas a un proyecto que está fuera de tu área de experiencia, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(84, 'Si descubres que un proyecto tiene un error significativo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(85, 'Si te enfrentas a una situación donde tienes que tomar una decisión rápida, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(86, 'Si tienes que delegar tareas, ¿cómo lo harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(87, 'Si descubres que un miembro del equipo está tomando atajos para cumplir con las metas, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(88, 'Si un cliente se muestra insatisfecho con el trabajo entregado, ¿cómo actuarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(89, 'Si te encuentras con un problema que no sabes cómo resolver, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(90, 'Si un compañero de trabajo no está cumpliendo con las expectativas del proyecto, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(91, 'Si un cliente pide un cambio de última hora en el proyecto, ¿cómo manejarías la solicitud?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(92, 'Si un equipo tiene un conflicto interno, ¿cómo lo resolverías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(93, 'Si un cliente no paga por un servicio prestado, ¿cómo manejarías la situación?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(94, 'Si tienes que elegir entre dos opciones que parecen igual de buenas, ¿cómo decidirías cuál tomar?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(95, 'Si te das cuenta de que un proyecto está fuera de control, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(96, 'Si te enfrentas a una situación que podría afectar tu reputación profesional, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(97, 'Si un cliente exige un servicio que no puedes ofrecer, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(98, 'Si te asignan un proyecto difícil pero con pocos recursos, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(99, 'Si un compañero hace un buen trabajo pero no recibe reconocimiento, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(100, 'Si un cliente solicita un cambio en los términos de un contrato después de haberlo firmado, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(101, 'Si alguien te da una crítica constructiva sobre tu desempeño, ¿cómo reaccionarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(102, 'Si un cliente está constantemente insatisfecho con el servicio, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(103, 'Si un compañero necesita apoyo urgente y no tienes tiempo para ayudar, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(104, 'Si te das cuenta de que estás tomando decisiones de manera impulsiva, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(105, 'Si necesitas realizar un cambio importante en un proyecto y sabes que no todos estarán de acuerdo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(106, 'Cuando un proyecto no avanza como se esperaba, ¿cómo reaccionas?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 1, 3),
(107, 'Si un miembro del equipo no está cumpliendo con su parte del trabajo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(108, '¿Cómo prefieres recibir retroalimentación de tus superiores?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(109, '¿Qué harías si un proyecto importante no tiene los recursos necesarios para completarse a tiempo?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(110, 'Si un compañero de trabajo tiene una idea que no estás de acuerdo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(111, 'Si descubrieras que un compañero está tomando crédito por tu trabajo, ¿cómo reaccionarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(112, 'Si te enteras de que un compañero está realizando actividades fraudulentas, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(113, 'Si un cliente ofrece un pago adicional para acelerar el proceso de trabajo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(114, 'Si un proyecto importante depende de información confidencial y accidentalmente la descubres, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(115, 'Si un superior te pide que tomes un atajo poco ético para terminar una tarea rápidamente, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(116, 'Si te enteras de que un miembro del equipo está mintiendo para encubrir errores, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(117, 'Si tienes que hacer una presentación de resultados y no estás completamente seguro de los datos, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(118, 'Si un compañero se beneficia de información que tú has compartido de manera inapropiada, ¿cómo reaccionarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(119, '¿Qué harías si un cliente te ofrece una gratificación para evitar un procedimiento complicado o largo?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(120, 'Si te encuentras con un error en una factura que fue emitida por un compañero, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(121, 'Si descubres que un proveedor ha ofrecido un descuento exclusivo solo a ti, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(122, 'Si un cliente te presiona para cambiar un informe que ya está finalizado, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(123, 'Si un compañero de trabajo se beneficia de una política que tú sabes que no se aplica correctamente, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(124, 'Si tuvieras que decidir entre dos propuestas que compiten por el mismo recurso y una de ellas está claramente fuera de lugar, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(125, 'Si alguien a tu cargo toma una decisión inapropiada que afecta al equipo, ¿cómo lo manejarías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(126, 'Si te das cuenta de que un proceso está siendo manipulado de forma ilegal, ¿cómo procederías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(127, 'Si un compañero te pide que informes de manera errónea para protegerlo de un error que cometió, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(128, 'Si sabes que un compañero de trabajo está siendo maltratado por un superior, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(129, '¿Qué harías si te enteras de que un cliente está siendo engañado por una mala práctica dentro de tu empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(130, 'Si descubres que un miembro del equipo está violando una política de la empresa, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(131, 'Si te ofrecieran un soborno para influir en un proceso, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(132, 'Si durante una auditoría encuentras una discrepancia que podría beneficiar a la empresa pero es ilegal, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(133, 'Si un compañero de trabajo te pide que ocultes información importante en un informe, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(134, 'Si descubres que un contrato contiene cláusulas que no son legales, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(135, '¿Qué harías si un colega te pide que sigas un procedimiento que sabes que está en contra de las reglas de la empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(136, 'Si te enteras de que alguien está siendo discriminado en el lugar de trabajo, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(137, 'Si un cliente te pide que realices una tarea fuera del alcance de tu responsabilidad, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(138, 'Si un compañero te muestra cómo manipular datos para hacer que los resultados se vean mejores, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(139, 'Si descubres que un contrato está siendo manipulado para beneficiar a alguien de manera ilegal, ¿qué harías?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(140, '¿Qué harías si te das cuenta de que un proyecto se está gestionando de manera inadecuada y perjudica a la empresa?', 'Prueba de Integridad de Reid (Reid Integrity Test)', 0, 3),
(141, '¿Alguna vez has tomado algo de una tienda sin pagar por ello?', 'Inventario de Honestidad de O’Connor', 1, 4),
(142, '¿Has copiado alguna vez en un examen o tarea?', 'Inventario de Honestidad de O’Connor', 0, 4),
(143, '¿Alguna vez has hecho trampa para obtener una ventaja en el trabajo?', 'Inventario de Honestidad de O’Connor', 0, 4),
(144, 'Si alguna vez te dieron más cambio de lo que te correspondía, ¿lo devolverías?', 'Inventario de Honestidad de O’Connor', 0, 4),
(145, '¿Te has quedado con algo que sabías que no te pertenecía?', 'Inventario de Honestidad de O’Connor', 0, 4),
(146, '¿Has mentido alguna vez para evitar una consecuencia negativa?', 'Inventario de Honestidad de O’Connor', 0, 4),
(147, '¿Alguna vez has tomado crédito por el trabajo de otra persona?', 'Inventario de Honestidad de O’Connor', 0, 4),
(148, '¿Alguna vez has utilizado información privada para obtener algún beneficio personal?', 'Inventario de Honestidad de O’Connor', 0, 4),
(149, 'Si accidentalmente te llevas algo de una tienda sin pagar, ¿lo devolverías?', 'Inventario de Honestidad de O’Connor', 0, 4),
(150, '¿Alguna vez has dejado de reportar algo porque pensaste que no era importante?', 'Inventario de Honestidad de O’Connor', 0, 4),
(151, '¿Consideras que está bien mentir en ciertas situaciones si no hay consecuencias graves?', 'Inventario de Honestidad de O’Connor', 0, 5),
(152, 'Si pudieras obtener un beneficio personal sin que nadie se enterara, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 5),
(153, '¿Crees que una persona que roba una pequeña cantidad de dinero o propiedad está haciendo algo grave?', 'Inventario de Honestidad de O’Connor', 0, 5),
(154, 'Si pudieras mentir para proteger a un amigo, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 5),
(155, '¿Consideras que hacer trampa en un entorno laboral está justificado si no hay riesgo de ser descubierto?', 'Inventario de Honestidad de O’Connor', 0, 5),
(156, 'Si te dieran un soborno pequeño para hacer algo que no es legal, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 5),
(157, '¿Es aceptable tomar algo de la oficina si nadie se da cuenta?', 'Inventario de Honestidad de O’Connor', 0, 5),
(158, 'Si un compañero te pidió que ocultaras un error que cometió, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 5),
(159, '¿Consideras que es válido ocultar información importante si eso ayuda a lograr un objetivo personal o profesional?', 'Inventario de Honestidad de O’Connor', 0, 5),
(160, 'Si fueras testigo de un robo en el trabajo y no hubiera consecuencias para ti, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 5),
(161, 'Si encuentras una cartera con dinero en la calle, ¿la devolverías?', 'Inventario de Honestidad de O’Connor', 1, 6),
(162, '¿Aceptarías un regalo de un cliente o proveedor si sabes que podría influir en una decisión que tomes en tu trabajo?', 'Inventario de Honestidad de O’Connor', 0, 6),
(163, 'Si un compañero comete un error pero nadie lo nota, ¿lo corregirías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(164, 'Si te ofrecieran una ventaja en tu trabajo a cambio de ayudar a alguien a ocultar un error, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(165, 'Si te enteraras de que alguien ha manipulado datos para obtener mejores resultados en su trabajo, ¿lo reportarías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(166, '¿Aceptarías usar información confidencial para obtener una ventaja sobre un competidor?', 'Inventario de Honestidad de O’Connor', 0, 6),
(167, 'Si un compañero se disculpa por un error que cometió, pero sabes que fue un acto deshonesto, ¿lo perdonarías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(168, '¿Alguna vez has callado una situación deshonesta porque pensaste que no te afectaría directamente?', 'Inventario de Honestidad de O’Connor', 0, 6),
(169, 'Si un compañero te ofreciera dinero a cambio de hacer algo que sabes que está mal, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(170, 'Si descubrieras que alguien ha falsificado documentos en el trabajo, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 6),
(171, '¿Qué tan importante es para ti ser honesto en el trabajo?', 'Inventario de Honestidad de O’Connor', 0, 7),
(172, '¿Crees que la honestidad siempre debería ser la principal prioridad, incluso si esto puede resultar en consecuencias negativas para ti?', 'Inventario de Honestidad de O’Connor', 0, 7),
(173, '¿Consideras que las reglas en el lugar de trabajo deben ser siempre seguidas, independientemente de las circunstancias?', 'Inventario de Honestidad de O’Connor', 0, 7),
(174, 'Si fueras elegido para liderar un proyecto importante, ¿considerarías la honestidad como uno de los factores más importantes para asegurar el éxito del proyecto?', 'Inventario de Honestidad de O’Connor', 0, 7),
(175, '¿Qué tan grave consideras que es violar las normas éticas, incluso si no hay consecuencias inmediatas?', 'Inventario de Honestidad de O’Connor', 0, 7),
(176, 'Si un compañero de trabajo te ofreciera información confidencial que podría beneficiarte, ¿la usarías?', 'Inventario de Honestidad de O’Connor', 1, 8),
(177, '¿Consideras que un error de contabilidad pequeño en una empresa es algo que se debe reportar siempre, aunque no cause daño inmediato?', 'Inventario de Honestidad de O’Connor', 0, 8),
(178, '¿Si un amigo te pidiera que le ayudases a ocultar algo ilegal que ha hecho, lo harías?', 'Inventario de Honestidad de O’Connor', 0, 8),
(179, 'Si tu jefe te pidiera que omitieses información en un informe importante para obtener mejores resultados, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 8),
(180, 'Si un cliente te ofreciera un soborno por realizar un servicio más rápido o con condiciones preferenciales, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 8),
(181, '¿Estás de acuerdo con que mentir puede ser aceptable en situaciones donde el beneficio personal es significativo y no daña a nadie?', 'Inventario de Honestidad de O’Connor', 0, 8),
(182, '¿Te parecería justo tomar un pequeño \"extra\" si sientes que tu empleador te ha tratado injustamente?', 'Inventario de Honestidad de O’Connor', 0, 8),
(183, 'Si descubrieras que tu empresa está involucrada en una actividad ilegal, ¿lo reportarías inmediatamente?', 'Inventario de Honestidad de O’Connor', 0, 8),
(184, 'Si alguien en tu equipo de trabajo comete un error que podría perjudicar a la empresa, pero no se dan cuenta, ¿lo informarías?', 'Inventario de Honestidad de O’Connor', 0, 8),
(185, 'Si un compañero de trabajo te pidiera que no mencionaras algo que crees que es importante, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 8),
(186, 'Si te dieran una cantidad extra de dinero sin que nadie lo notara, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 1, 9),
(187, 'Si un cliente te pidiera que mintieras sobre la calidad de un producto para cerrar una venta, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 9),
(188, '¿Crees que es aceptable recibir un beneficio personal de la empresa si nadie se entera y no afecta a otros?', 'Inventario de Honestidad de O’Connor', 0, 9),
(189, 'Si consideras que una mentira piadosa no causa daño, ¿la usarías para evitar una situación incómoda?', 'Inventario de Honestidad de O’Connor', 0, 9),
(190, 'Si un compañero de trabajo te pidiera que escondieras un pequeño error para evitar consecuencias negativas para él, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 9),
(191, '¿Estarías dispuesto a dejar de informar sobre una violación menor de las reglas si crees que las consecuencias son excesivas?', 'Inventario de Honestidad de O’Connor', 0, 9),
(192, 'Si consideras que tu empresa no está ofreciendo el pago justo por tu trabajo, ¿te parece justificado tomar algo de la empresa?', 'Inventario de Honestidad de O’Connor', 0, 9),
(193, 'Si pudieras conseguir una ventaja significativa para ti sin que nadie lo supiera, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 9),
(194, '¿Estás de acuerdo con la idea de que si una persona no es atrapada cometiendo un acto deshonesto, no tiene por qué ser considerado un error?', 'Inventario de Honestidad de O’Connor', 0, 9),
(195, 'Si al no reportar un error, puedes evitar una penalización para tu equipo, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 9),
(196, 'Si encuentras un error en un informe y te das cuenta de que puede beneficiarte, ¿lo corregirías?', 'Inventario de Honestidad de O’Connor', 1, 10),
(197, 'Si un compañero se beneficia de una falta en las políticas de la empresa y no lo denuncia nadie, ¿te parecería correcto no hacer nada?', 'Inventario de Honestidad de O’Connor', 0, 10),
(198, 'Si descubres que tu jefe ha ocultado información para obtener un beneficio personal, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 10),
(199, 'Si otro empleado ha tomado una ventaja de la empresa sin consecuencias, ¿considerarías que eso es una mala práctica?', 'Inventario de Honestidad de O’Connor', 0, 10),
(200, '¿Deberían las empresas tolerar el pequeño fraude si no afecta a las ganancias generales?', 'Inventario de Honestidad de O’Connor', 0, 10),
(201, 'Si un compañero de trabajo te ofreciera dinero a cambio de no reportar un error de la empresa, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 10),
(202, 'Si descubres que un colega ha manipulado datos para conseguir más crédito, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 10),
(203, 'Si en tu trabajo hay una política que consideras innecesaria o injusta, ¿te parece justificado romperla para facilitar tu trabajo?', 'Inventario de Honestidad de O’Connor', 0, 10),
(204, 'Si un error cometido por un superior fuera muy grave, pero no tuviera repercusiones inmediatas, ¿lo corregirías?', 'Inventario de Honestidad de O’Connor', 0, 10),
(205, 'Si en tu empresa te piden tomar un atajo que implica deshonestidad, ¿te parecería correcto hacerlo?', 'Inventario de Honestidad de O’Connor', 0, 10),
(206, 'Si pudieras evitar una reprimenda por un error pequeño a costa de ocultarlo, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 1, 11),
(207, 'Si un compañero te pide que no digas la verdad en una situación delicada, ¿lo harías para protegerlo?', 'Inventario de Honestidad de O’Connor', 0, 11),
(208, 'Si tus superiores te pidieran que alteraras un informe de rendimiento, ¿lo harías para evitar conflictos?', 'Inventario de Honestidad de O’Connor', 0, 11),
(209, 'Si una mentira podría mejorar significativamente tu situación personal, ¿la dirías?', 'Inventario de Honestidad de O’Connor', 0, 11),
(210, 'Si te ofrecieran una posición más alta a cambio de esconder un error, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 11),
(211, '¿Es importante ser honesto incluso si eso significa enfrentar consecuencias negativas?', 'Inventario de Honestidad de O’Connor', 1, 12),
(212, 'Si un compañero es honesto pero eso podría perjudicar la imagen de la empresa, ¿lo apoyarías?', 'Inventario de Honestidad de O’Connor', 0, 12),
(213, 'Si un compañero de trabajo te ofreciera una ventaja a cambio de no decir la verdad sobre una situación, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 12),
(214, '¿Crees que la honestidad es siempre más importante que los resultados inmediatos en el trabajo?', 'Inventario de Honestidad de O’Connor', 0, 12),
(215, 'Si una persona comete una falta ética pero no la perjudica de manera directa, ¿debería ser castigada por ello?', 'Inventario de Honestidad de O’Connor', 0, 12),
(216, 'Si un compañero de trabajo comete una falta que podría dañar a la empresa, pero no se enteran de ella, ¿deberías actuar para corregirla?', 'Inventario de Honestidad de O’Connor', 1, 13),
(217, 'Si te enteras de que un compañero de trabajo está haciendo trampas para cumplir con su cuota de ventas, ¿lo reportarías?', 'Inventario de Honestidad de O’Connor', 0, 13),
(218, 'Si descubres que alguien ha usado materiales de la empresa para un beneficio personal sin que nadie se entere, ¿lo consideras un comportamiento aceptable?', 'Inventario de Honestidad de O’Connor', 0, 13),
(219, 'Si un amigo te pidiera que ocultaras información importante que podría afectar su reputación, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 13),
(220, 'Si ves a un compañero manipular datos en un informe para mejorar su desempeño, ¿lo dejarías pasar sin reportarlo?', 'Inventario de Honestidad de O’Connor', 0, 13),
(221, '¿Estarías dispuesto a omitir información importante en un informe si eso asegurara que obtuvieras un ascenso?', 'Inventario de Honestidad de O’Connor', 0, 13),
(222, 'Si un compañero de trabajo te ofreciera una ventaja personal a cambio de ocultar un error, ¿la aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 13),
(223, 'Si en tu equipo de trabajo se ocultara un error para no perder un cliente importante, ¿te parecería bien hacerlo?', 'Inventario de Honestidad de O’Connor', 0, 13),
(224, '¿Consideras que algunas mentiras pequeñas son aceptables si no causan daño directo?', 'Inventario de Honestidad de O’Connor', 0, 13),
(225, 'Si un miembro de tu equipo te pidiera que cubrieras su error para evitar una sanción, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 13),
(226, 'Si un amigo cercano te pidiera un favor que podría influir en tu desempeño laboral, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 1, 14),
(227, 'Si tu empresa te ofreciera un beneficio personal por recomendar a un candidato que no cumple con todos los requisitos, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(228, '¿Considerarías correcto aceptar una invitación costosa de un proveedor si no influye directamente en tus decisiones profesionales?', 'Inventario de Honestidad de O’Connor', 0, 14),
(229, 'Si tu jefe te pidiera que asignaras una tarea importante a una persona que no es la más capacitada, pero que es amigo cercano de él, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(230, 'Si un cliente te ofreciera un regalo costoso por un servicio especial, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(231, 'Si un colega de otro departamento te ofrece información privilegiada para ayudarte en una negociación, ¿la usarías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(232, 'Si te ofrecieran un beneficio personal por firmar un acuerdo con un proveedor que no cumple con los estándares de calidad, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(233, 'Si fueras testigo de un comportamiento éticamente cuestionable de un compañero que podría beneficiarse personalmente, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(234, 'Si te dieran la oportunidad de aprovecharte de un trato favorable con un proveedor debido a tu relación personal con ellos, ¿lo aceptarías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(235, 'Si descubrieras que tu compañero de trabajo tiene un conflicto de intereses, ¿lo reportarías?', 'Inventario de Honestidad de O’Connor', 0, 14),
(236, 'Si accidentalmente tomaras más tiempo del necesario para completar una tarea que fue asignada a otro miembro del equipo, ¿informarías sobre el error?', 'Inventario de Honestidad de O’Connor', 1, 15),
(237, 'Si cometieras un error en un proyecto y no hubiera consecuencias inmediatas, ¿lo corregirías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(238, 'Si un compañero comete un error que afecta el progreso de un proyecto, pero el cliente no lo nota, ¿lo informarías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(239, 'Si te dieran una tarea en la que no tienes experiencia y, como resultado, cometes un error, ¿aceptarías tu responsabilidad?', 'Inventario de Honestidad de O’Connor', 0, 15),
(240, 'Si al final del día te das cuenta de que no has entregado un informe importante y nadie lo nota, ¿lo entregarías al día siguiente?', 'Inventario de Honestidad de O’Connor', 0, 15),
(241, 'Si tienes la oportunidad de mejorar el desempeño de tu equipo a costa de violar una regla menor, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(242, 'Si te pidieran que informaras un error en el sistema que beneficia a la empresa, pero que podría perjudicar tu desempeño personal, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(243, 'Si estuvieras tentado a manipular una cifra en un informe para que la empresa se vea mejor ante los directivos, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(244, 'Si un colega te pide que omitas ciertos detalles en un informe para facilitar la venta de un producto, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(245, 'Si sabes que alguien en tu equipo no está cumpliendo con las normas de la empresa pero no ha causado problemas, ¿lo reportarías?', 'Inventario de Honestidad de O’Connor', 0, 15),
(246, '¿Crees que es importante ser honesto siempre, incluso si eso puede llevar a una reprimenda?', 'Inventario de Honestidad de O’Connor', 1, 16),
(247, 'Si un error cometido por un superior podría perjudicar la imagen de la empresa, ¿lo informarías?', 'Inventario de Honestidad de O’Connor', 0, 16),
(248, 'Si pudieras tomar ventaja de una situación que podría beneficiar a tu equipo, pero sería injusto para otros, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 16),
(249, '¿Consideras que es mejor ser honesto incluso si eso significa enfrentar consecuencias negativas, que mentir para evitar problemas?', 'Inventario de Honestidad de O’Connor', 0, 16),
(250, 'Si descubres que un compañero está tomando algo de la empresa sin permiso, pero no tiene consecuencias, ¿lo denunciarías?', 'Inventario de Honestidad de O’Connor', 0, 16),
(251, 'Si ves a un compañero aprovechándose de una situación sin que nadie lo note, ¿qué harías?', 'Inventario de Honestidad de O’Connor', 1, 17),
(252, '¿Cómo te sentirías si, sin querer, cometieras un error en tu trabajo que podría afectar a tus compañeros o a la empresa?', 'Inventario de Honestidad de O’Connor', 0, 17),
(253, 'Si estuvieras en una situación en la que tu jefe te pidiera que omitieses un detalle menor en un informe para hacer que la información fuera más favorable, ¿cómo te sentirías?', 'Inventario de Honestidad de O’Connor', 0, 17),
(254, 'En tu opinión, ¿cuál es el mayor desafío que enfrentas para mantenerte honesto en el trabajo?', 'Inventario de Honestidad de O’Connor', 0, 17),
(255, 'Si un compañero te pide un consejo sobre cómo manejar una situación ética difícil, ¿cómo reaccionarías?', 'Inventario de Honestidad de O’Connor', 0, 17),
(256, 'Cuando alguien te hace un favor, ¿sientes la necesidad de devolverlo?', 'Inventario de Honestidad de O’Connor', 0, 17),
(257, 'Si un amigo cercano o colega está haciendo algo que sabes que no está bien, pero no te involucra directamente, ¿cómo reaccionarías?', 'Inventario de Honestidad de O’Connor', 0, 17),
(258, 'Si descubres que un compañero de trabajo está luchando con un problema personal que afecta su desempeño, ¿qué harías?', 'Inventario de Honestidad de O’Connor', 0, 17),
(259, 'Cuando piensas en tomar una decisión difícil que podría afectar tu reputación, ¿qué es lo primero que piensas?', 'Inventario de Honestidad de O’Connor', 0, 17),
(260, 'Si en tu trabajo te dieran la oportunidad de tomar un atajo que podría darte resultados inmediatos pero con un costo ético, ¿cómo reaccionarías?', 'Inventario de Honestidad de O’Connor', 0, 17),
(261, '¿Qué tan importante es para ti ser honesto con los demás en tu vida personal?', 'Inventario de Honestidad de O’Connor', 1, 18),
(262, '¿Cómo te sentirías si alguien te hiciera una pregunta incómoda pero legítima en una entrevista de trabajo?', 'Inventario de Honestidad de O’Connor', 0, 18),
(263, 'Si fueras testigo de que un compañero está siendo injustamente acusado de algo que no hizo, ¿qué harías?', 'Inventario de Honestidad de O’Connor', 0, 18),
(264, 'En una situación en la que podrías obtener un beneficio personal a través de una mentira pequeña, ¿lo harías?', 'Inventario de Honestidad de O’Connor', 0, 18),
(265, 'Si te encontraras en una posición en la que tu integridad se viera cuestionada, ¿cómo manejarías la situación?', 'Inventario de Honestidad de O’Connor', 0, 18);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_pregunta_y_respuesta_correcta`
--

DROP TABLE IF EXISTS `psico_alobri_pregunta_y_respuesta_correcta`;
CREATE TABLE IF NOT EXISTS `psico_alobri_pregunta_y_respuesta_correcta` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pregunta_id` int NOT NULL,
  `respuesta_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pregunta_id` (`pregunta_id`),
  KEY `respuesta_id` (`respuesta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_pregunta_y_respuesta_correcta`
--

INSERT INTO `psico_alobri_pregunta_y_respuesta_correcta` (`id`, `pregunta_id`, `respuesta_id`) VALUES
(1, 1, 2),
(2, 2, 5),
(3, 3, 6),
(4, 4, 9),
(5, 5, 12),
(6, 6, 13),
(7, 7, 17),
(8, 8, 19),
(9, 9, 21),
(10, 10, 24),
(11, 11, 26),
(12, 12, 28),
(13, 13, 30),
(14, 14, 32),
(15, 15, 34),
(16, 16, 37),
(17, 17, 39),
(18, 18, 41),
(19, 19, 43),
(20, 20, 45),
(21, 21, 47),
(22, 22, 49),
(23, 23, 51),
(24, 24, 53),
(25, 25, 55),
(26, 26, 57),
(27, 27, 59),
(28, 28, 61),
(29, 29, 62),
(30, 30, 64),
(31, 31, 67),
(32, 32, 69),
(33, 33, 71),
(34, 34, 73),
(35, 35, 75);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_respuestas`
--

DROP TABLE IF EXISTS `psico_alobri_respuestas`;
CREATE TABLE IF NOT EXISTS `psico_alobri_respuestas` (
  `respuesta_id` int NOT NULL,
  `respuesta` varchar(200) NOT NULL,
  `opcion` char(1) NOT NULL,
  `pregunta_id` int NOT NULL,
  PRIMARY KEY (`respuesta_id`),
  KEY `pregunta_id` (`pregunta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_respuestas`
--

INSERT INTO `psico_alobri_respuestas` (`respuesta_id`, `respuesta`, `opcion`, `pregunta_id`) VALUES
(1, 'Lo tomaría para mí', 'a', 1),
(2, 'Lo devolvería al dueño', 'b', 1),
(3, 'Lo entregaría al jefe', 'c', 1),
(4, 'Sí', 'a', 2),
(5, 'No', 'b', 2),
(6, 'Sí', 'a', 3),
(7, 'No', 'b', 3),
(8, 'Ignoraría el problema', 'a', 4),
(9, 'Hablaría con él directamente', 'b', 4),
(10, 'Lo reportaría a un superior', 'c', 4),
(11, 'Sí', 'a', 5),
(12, 'No', 'b', 5),
(13, 'Le diría que no es posible omitir la información', 'a', 6),
(14, 'Aceptaría su petición', 'b', 6),
(15, 'Diría que tengo que consultar con un supervisor antes de dar una respuesta', 'c', 6),
(16, 'Sí', 'a', 7),
(17, 'No', 'b', 7),
(18, 'Sí', 'a', 8),
(19, 'No', 'b', 8),
(20, 'Sí', 'a', 9),
(21, 'No', 'b', 9),
(22, 'Lo leería', 'a', 10),
(23, 'Lo ignoraría', 'b', 10),
(24, 'Lo devolvería o informaría a Recursos Humanos', 'c', 10),
(25, 'Lo haría', 'a', 11),
(26, 'Me negaría a hacerlo', 'b', 11),
(27, 'Sí', 'a', 12),
(28, 'No', 'b', 12),
(29, 'Sí', 'a', 13),
(30, 'No', 'b', 13),
(31, 'Ignoraría el retraso', 'a', 14),
(32, 'Le preguntaría si necesita ayuda', 'b', 14),
(33, 'Lo reportaría a un supervisor', 'c', 14),
(34, 'Sí', 'a', 15),
(35, 'No', 'b', 15),
(36, 'Lo ignoraría', 'a', 16),
(37, 'Lo reportaría', 'b', 16),
(38, 'Sí', 'a', 17),
(39, 'No', 'b', 17),
(40, 'Sí', 'a', 18),
(41, 'No', 'b', 18),
(42, 'Sí', 'a', 19),
(43, 'No', 'b', 19),
(44, 'Lo dejaría pasar', 'a', 20),
(45, 'Hablaría con él sobre la situación', 'b', 20),
(46, 'Sí', 'a', 21),
(47, 'No', 'b', 21),
(48, 'Sí', 'a', 22),
(49, 'No', 'b', 22),
(50, 'Lo tomaría para mí', 'a', 23),
(51, 'Lo entregaría a Recursos Humanos', 'b', 23),
(52, 'Lo haría', 'a', 24),
(53, 'No lo haría', 'b', 24),
(54, 'Aceptaría la culpa', 'a', 25),
(55, 'Buscaría la manera de corregir la situación', 'b', 25),
(56, 'Lo haría', 'a', 26),
(57, 'Lo discutiría con él', 'b', 26),
(58, 'Sí', 'a', 27),
(59, 'No', 'b', 27),
(60, 'Sí', 'a', 28),
(61, 'No', 'b', 28),
(62, 'Sí', 'a', 29),
(63, 'No', 'b', 29),
(64, 'Le explicaría que no es posible', 'a', 30),
(65, 'Aceptaría la solicitud', 'b', 30),
(66, 'Sí', 'a', 31),
(67, 'No', 'b', 31),
(68, 'Sí', 'a', 32),
(69, 'No', 'b', 32),
(70, 'Sí', 'a', 33),
(71, 'No', 'b', 33),
(72, 'Ignoraría el problema', 'a', 34),
(73, 'Lo confrontaría', 'b', 34),
(74, 'Lo haría', 'a', 35),
(75, 'No lo haría', 'b', 35),
(76, 'Lo corregiría inmediatamente', 'a', 36),
(77, 'Lo ignoraría si nadie más lo nota', 'b', 36),
(78, 'Ayudaría', 'a', 37),
(79, 'Le diría que no puedo ayudar', 'b', 37),
(80, 'Cumpliría con la orden sin cuestionarla', 'a', 38),
(81, 'Expresaría mi desacuerdo de manera respetuosa y luego cumpliría', 'b', 38),
(82, 'Sí', 'a', 39),
(83, 'No', 'b', 39),
(84, 'Lo informaría al cliente y a mi supervisor', 'a', 40),
(85, 'No intervendría', 'b', 40),
(86, 'Aceptaría la información', 'a', 41),
(87, 'Lo rechazaría y le diría que no puedo aceptar esa información', 'b', 41),
(88, 'Aceptaría la solicitud', 'a', 42),
(89, 'Le explicaría al cliente por qué no puedo aceptar su solicitud', 'b', 42),
(90, 'Aceptaría la oferta', 'a', 43),
(91, 'Rechazaría la oferta y lo informaría a mi superior', 'b', 43),
(92, 'Sí', 'a', 44),
(93, 'No', 'b', 44),
(94, 'Cumpliría con la petición', 'a', 45),
(95, 'Buscaría una alternativa que no perjudique la reputación', 'b', 45),
(96, 'Sí', 'a', 46),
(97, 'No', 'b', 46),
(98, 'Sí', 'a', 47),
(99, 'No', 'b', 47),
(100, 'Sí', 'a', 48),
(101, 'No', 'b', 48),
(102, 'Lo denunciaría', 'a', 49),
(103, 'Ignoraría la situación', 'b', 49),
(104, 'Sí', 'a', 50),
(105, 'No', 'b', 50),
(106, 'Lo denunciaría', 'a', 51),
(107, 'Lo ignoraría', 'b', 51),
(108, 'Lo haría', 'a', 52),
(109, 'Le explicaría que no es posible realizarlo', 'b', 52),
(110, 'No diría nada', 'a', 53),
(111, 'Hablaría con él directamente', 'b', 53),
(112, 'Lo confrontaría y explicaría mi error', 'a', 54),
(113, 'No diría nada', 'b', 54),
(114, 'Lo haría', 'a', 55),
(115, 'Le diría que no puedo hacerlo', 'b', 55),
(116, 'Lo ignoraría', 'a', 56),
(117, 'Lo corregiría de manera profesional', 'b', 56),
(118, 'Lo ayudaría', 'a', 57),
(119, 'Le explicaría que debe asumir su responsabilidad', 'b', 57),
(120, 'Lo aceptaría', 'a', 58),
(121, 'Lo rechazaría', 'b', 58),
(122, 'Lo denunciaría', 'a', 59),
(123, 'Lo ignoraría', 'b', 59),
(124, 'Sí', 'a', 60),
(125, 'No', 'b', 60),
(126, 'Lo cubriría', 'a', 61),
(127, 'Informaría a mi jefe y al cliente para rectificar el error', 'b', 61),
(128, 'Sí', 'a', 62),
(129, 'No', 'b', 62),
(130, 'Sí', 'a', 63),
(131, 'No', 'b', 63),
(132, 'Lo ignoraría', 'a', 64),
(133, 'Lo reportaría a la persona adecuada', 'b', 64),
(134, 'Participaría', 'a', 65),
(135, 'Rechazaría la invitación', 'b', 65),
(136, 'Lo denunciaría', 'a', 66),
(137, 'Lo dejaría pasar', 'b', 66),
(138, 'Ignoraría la situación', 'a', 67),
(139, 'Lo reportaría a las autoridades correspondientes', 'b', 67),
(140, 'Lo cubriría', 'a', 68),
(141, 'No lo cubriría', 'b', 68),
(142, 'Lo informaría a un superior para mejorar la transparencia', 'a', 69),
(143, 'No diría nada', 'b', 69),
(144, 'Lo usaría sin problemas', 'a', 70),
(145, 'Rechazaría el acceso y lo informaría', 'b', 70),
(146, 'Lo ignoraría y lo dejaría pasar', 'a', 71),
(147, 'Analizaría la situación y buscaría una solución adecuada', 'b', 71),
(148, 'Aceptaría su solución sin discutirla', 'a', 72),
(149, 'Propondría mi punto de vista de manera respetuosa y buscaríamos una solución conjunta', 'b', 72),
(150, 'Tomaría la decisión que me beneficia personalmente', 'a', 73),
(151, 'Buscaría la solución más ética que beneficie a la empresa y a las personas involucradas', 'b', 73),
(152, 'Esperaría a que las cosas se solucionen solas', 'a', 74),
(153, 'Evaluaría el progreso y realizaría ajustes para asegurar que se cumplan los plazos', 'b', 74),
(154, 'Tomaría una decisión rápida sin preocuparte por la falta de información', 'a', 75),
(155, 'Buscaría la información que me falta antes de tomar una decisión', 'b', 75),
(156, 'Lo ignoraría', 'a', 76),
(157, 'Hablaría con él de manera directa y le ofrecería apoyo para mejorar su desempeño', 'b', 76),
(158, 'Ignoraría el problema', 'a', 77),
(159, 'Identificaría la causa raíz y trabajaría para resolverlo en conjunto con el equipo', 'b', 77),
(160, 'Lo resolvería de manera rápida y sin consultarlo con nadie', 'a', 78),
(161, 'Consultaría con un superior o con el departamento de ética para encontrar una solución adecuada', 'b', 78),
(162, 'Aceptaría la solicitud sin cuestionarla', 'a', 79),
(163, 'Le explicaría al cliente las posibles consecuencias y buscaría una alternativa', 'b', 79),
(164, 'Continuaría con el proyecto tal como está', 'a', 80),
(165, 'Revisaría la planificación y realizaría ajustes para mejorar el desarrollo', 'b', 80),
(166, 'Tomaría la decisión basándome en lo que parece más rápido', 'a', 81),
(167, 'Evaluaría los pros y los contras de cada opción y tomaría la decisión más informada', 'b', 81),
(168, 'Lo ignoraría', 'a', 82),
(169, 'Lo discutiría con él y buscaría una solución que sea justa para todos', 'b', 82),
(170, 'Lo rechazaría y no me involucraría', 'a', 83),
(171, 'Buscaría apoyo de colegas con más experiencia y aprendería sobre el tema', 'b', 83),
(172, 'Esperaría a que alguien más lo note', 'a', 84),
(173, 'Informaría de inmediato a mi superior y trabajaría para corregirlo', 'b', 84),
(174, 'Tomaría una decisión sin pensar demasiado', 'a', 85),
(175, 'Evaluaría rápidamente las opciones y tomaría la decisión más adecuada', 'b', 85),
(176, 'Delegaría las tareas sin explicar mucho', 'a', 86),
(177, 'Asignaría las tareas de acuerdo con las fortalezas de cada miembro y les daría la información necesaria para realizarlas', 'b', 86),
(178, 'Lo ignoraría', 'a', 87),
(179, 'Hablaría con él para asegurarme de que se sigan los procedimientos adecuados', 'b', 87),
(180, 'Ignoraría su queja', 'a', 88),
(181, 'Escucharía sus comentarios, disculparía el error y tomaría medidas para corregirlo', 'b', 88),
(182, 'Intentaría resolverlo por mi cuenta sin pedir ayuda', 'a', 89),
(183, 'Buscaría ayuda de un colega o supervisor con más experiencia', 'b', 89),
(184, 'Lo criticaría abiertamente', 'a', 90),
(185, 'Hablaría con él en privado y ofrecería mi ayuda para mejorar su desempeño', 'b', 90),
(186, 'Aceptaría el cambio sin considerar sus implicaciones', 'a', 91),
(187, 'Evaluaría las implicaciones del cambio y comunicaría al cliente si es factible implementarlo', 'b', 91),
(188, 'Ignoraría el conflicto para evitar confrontaciones', 'a', 92),
(189, 'Organizaría una reunión para resolver el conflicto de manera constructiva', 'b', 92),
(190, 'No haría nada y dejaría que el cliente decida si paga', 'a', 93),
(191, 'Intentaría contactar al cliente y encontrar una solución para el pago', 'b', 93),
(192, 'Tomaría la decisión basada en mi intuición', 'a', 94),
(193, 'Analizaría todos los factores posibles antes de tomar una decisión', 'b', 94),
(194, 'Ignoraría el problema', 'a', 95),
(195, 'Tomaría medidas inmediatas para redirigir el proyecto y hacerlo más manejable', 'b', 95),
(196, 'Trataría de ocultarlo', 'a', 96),
(197, 'Buscaría resolver la situación de manera ética y profesional', 'b', 96),
(198, 'Lo rechazaría sin explicaciones', 'a', 97),
(199, 'Explicaría educadamente por qué no puedo ofrecer ese servicio y ofrecería alternativas', 'b', 97),
(200, 'No haría nada al respecto', 'a', 98),
(201, 'Buscaría soluciones creativas y aprovecharía al máximo los recursos disponibles', 'b', 98),
(202, 'No diría nada', 'a', 99),
(203, 'Lo felicitaría y sugeriría a mi supervisor reconocer su trabajo', 'b', 99),
(204, 'Aceptaría el cambio sin cuestionarlo', 'a', 100),
(205, 'Le explicaría que no se puede modificar el contrato sin los procedimientos adecuados', 'b', 100),
(206, 'Me sentiría ofendido y lo ignoraría', 'a', 101),
(207, 'Escucharía atentamente y utilizaría la crítica para mejorar', 'b', 101),
(208, 'Ignoraría sus quejas', 'a', 102),
(209, 'Intentaría identificar la causa de su insatisfacción y ofrecerle una solución', 'b', 102),
(210, 'Lo ignoraría', 'a', 103),
(211, 'Intentaría hacer el tiempo necesario para ofrecerle la ayuda', 'b', 103),
(212, 'Seguiría tomando decisiones rápidamente', 'a', 104),
(213, 'Intentaría tomar un momento para reflexionar antes de tomar decisiones importantes', 'b', 104),
(214, 'Impondría el cambio sin consultar', 'a', 105),
(215, 'Explicaría las razones detrás del cambio y buscaría la aceptación del equipo', 'b', 105),
(216, 'Me frustro y busco culpar a otros', 'a', 106),
(217, 'Analizo lo que salió mal y busco soluciones con el equipo', 'b', 106),
(218, 'Ignoraría la situación para evitar conflictos', 'a', 107),
(219, 'Hablaría directamente con la persona para entender su situación y encontrar una solución', 'b', 107),
(220, 'De forma directa y honesta, sin suavizar las críticas', 'a', 108),
(221, 'Prefiero que se me dé de manera más suave y con tacto', 'b', 108),
(222, 'Intentaría hacerlo con los recursos limitados sin buscar alternativas', 'a', 109),
(223, 'Buscaría soluciones alternativas o negociaría más recursos para asegurar el éxito del proyecto', 'b', 109),
(224, 'Desacreditaría la idea de inmediato', 'a', 110),
(225, 'Escucharía la idea, la analizaría y daría mi opinión de manera respetuosa', 'b', 110),
(226, 'No haría nada y lo dejaría pasar', 'a', 111),
(227, 'Hablaría con la persona de manera respetuosa y plantearía mi perspectiva', 'b', 111),
(228, 'No haría nada para no causar problemas', 'a', 112),
(229, 'Informaría a mi superior sobre la situación', 'b', 112),
(230, 'Aceptaría el pago sin pensarlo', 'a', 113),
(231, 'Rechazaría el pago y seguiría el proceso estándar', 'b', 113),
(232, 'Usaría la información para obtener ventaja', 'a', 114),
(233, 'Mantendría la confidencialidad y no usaría la información', 'b', 114),
(234, 'Lo haría para evitar problemas', 'a', 115),
(235, 'Explicaría por qué no es correcto y buscaría una solución alternativa', 'b', 115),
(236, 'Ignoraría la situación para evitar conflictos', 'a', 116),
(237, 'Hablaría con la persona y sugeriría que sea honesto para resolver el problema', 'b', 116),
(238, 'Los presentaría tal cual, esperando que no se noten los errores', 'a', 117),
(239, 'Verificaría los datos antes de la presentación o dejaría claro que son preliminares', 'b', 117),
(240, 'No haría nada para evitar crear un conflicto', 'a', 118),
(241, 'Hablaría con la persona y le pediría que no usara la información de manera inapropiada', 'b', 118),
(242, 'Aceptaría la gratificación, ya que el procedimiento puede ser largo', 'a', 119),
(243, 'Rechazaría la gratificación y seguiría el procedimiento según lo establecido', 'b', 119),
(244, 'No haría nada, ya que no me afecta directamente', 'a', 120),
(245, 'Informaría al compañero o a la persona correspondiente para que se pueda corregir el error', 'b', 120),
(246, 'Aprovecharía el descuento sin decir nada', 'a', 121),
(247, 'Rechazaría el descuento, ya que no es ético aceptar ofertas exclusivas sin la aprobación del equipo', 'b', 121),
(248, 'Cambiaría el informe para satisfacer al cliente', 'a', 122),
(249, 'Explicaría por qué el informe debe mantenerse tal como está, incluso si no es lo que el cliente quiere', 'b', 122),
(250, 'No haría nada, ya que no me afecta directamente', 'a', 123),
(251, 'Hablaría con la persona para explicarle la política correcta o informaría al responsable para corregir la situación', 'b', 123),
(252, 'Elegiría la propuesta que beneficia más a mi equipo, incluso si es menos justa', 'a', 124),
(253, 'Escogería la propuesta más justa y de acuerdo con las políticas de la empresa', 'b', 124),
(254, 'Dejaría que el problema se resuelva por sí solo', 'a', 125),
(255, 'Hablaría con la persona y la orientaría sobre cómo corregir la situación', 'b', 125),
(256, 'Ignoraría el problema, ya que no me involucra', 'a', 126),
(257, 'Informaría a las autoridades correspondientes para que se investigue', 'b', 126),
(258, 'Aceptaría el pedido para evitar conflictos', 'a', 127),
(259, 'Rechazaría el pedido y le aconsejaría que asuma la responsabilidad de su error', 'b', 127),
(260, 'Ignoraría la situación para evitar problemas', 'a', 128),
(261, 'Hablaría con el compañero para ofrecerle apoyo y consideraría informarlo a recursos humanos si es necesario', 'b', 128),
(262, 'Lo ignoraría ya que no soy responsable', 'a', 129),
(263, 'Informaría al cliente de manera ética y buscaría resolver el problema', 'b', 129),
(264, 'Lo ignoraría para evitar conflictos', 'a', 130),
(265, 'Hablaría con la persona y le recordaría la política de la empresa, o lo informaría a los responsables si es necesario', 'b', 130),
(266, 'Aceptaría el soborno, ya que podría beneficiarme', 'a', 131),
(267, 'Rechazaría el soborno y denunciaría la oferta', 'b', 131),
(268, 'Ignoraría la discrepancia para no crear problemas', 'a', 132),
(269, 'Informaría sobre la discrepancia y buscaría una solución ética', 'b', 132),
(270, 'Aceptaría la solicitud para mantener la armonía', 'a', 133),
(271, 'Me negaría a ocultar información y le explicaría la importancia de ser transparente', 'b', 133),
(272, 'No haría nada para evitar conflictos', 'a', 134),
(273, 'Hablaría con el equipo legal para corregir las cláusulas', 'b', 134),
(274, 'Seguiría las indicaciones para evitar problemas', 'a', 135),
(275, 'Le explicaría que el procedimiento no es adecuado y buscaría una solución que esté dentro de las reglas', 'b', 135),
(276, 'Lo ignoraría, ya que no es mi problema', 'a', 136),
(277, 'Hablaría con la persona afectada para ofrecer apoyo y lo reportaría a recursos humanos', 'b', 136),
(278, 'Aceptaría la tarea para complacer al cliente', 'a', 137),
(279, 'Explicaría que no puedo realizar la tarea fuera de mis responsabilidades y buscaría una alternativa', 'b', 137),
(280, 'Lo seguiría para evitar confrontaciones', 'a', 138),
(281, 'Me negaría y le explicaría que manipular los datos es incorrecto', 'b', 138),
(282, 'Ignoraría la situación para evitar problemas', 'a', 139),
(283, 'Denunciaría la manipulación para garantizar que el contrato se maneje correctamente', 'b', 139),
(284, 'Esperaría que la situación se resuelva por sí sola', 'a', 140),
(285, 'Hablaría con los responsables para encontrar una solución y mejorar la situación', 'b', 140),
(286, 'Sí', 'a', 141),
(287, 'No', 'b', 141),
(288, 'Sí', 'a', 142),
(289, 'No', 'b', 142),
(290, 'Sí', 'a', 143),
(291, 'No', 'b', 143),
(292, 'Sí', 'a', 144),
(293, 'No', 'b', 144),
(294, 'Sí', 'a', 145),
(295, 'No', 'b', 145),
(296, 'Sí', 'a', 146),
(297, 'No', 'b', 146),
(298, 'Sí', 'a', 147),
(299, 'No', 'b', 147),
(300, 'Sí', 'a', 148),
(301, 'No', 'b', 148),
(302, 'Sí', 'a', 149),
(303, 'No', 'b', 149),
(304, 'Sí', 'a', 150),
(305, 'No', 'b', 150),
(306, 'Sí', 'a', 151),
(307, 'No', 'b', 151),
(308, 'Sí', 'a', 152),
(309, 'No', 'b', 152),
(310, 'Sí', 'a', 153),
(311, 'No', 'b', 153),
(312, 'Sí', 'a', 154),
(313, 'No', 'b', 154),
(314, 'Sí', 'a', 155),
(315, 'No', 'b', 155),
(316, 'Sí', 'a', 156),
(317, 'No', 'b', 156),
(318, 'Sí', 'a', 157),
(319, 'No', 'b', 157),
(320, 'Sí', 'a', 158),
(321, 'No', 'b', 158),
(322, 'Sí', 'a', 159),
(323, 'No', 'b', 159),
(324, 'Sí', 'a', 160),
(325, 'No', 'b', 160),
(326, 'Sí', 'a', 161),
(327, 'No', 'b', 161),
(328, 'Sí', 'a', 162),
(329, 'No', 'b', 162),
(330, 'Sí', 'a', 163),
(331, 'No', 'b', 163),
(332, 'Sí', 'a', 164),
(333, 'No', 'b', 164),
(334, 'Sí', 'a', 165),
(335, 'No', 'b', 165),
(336, 'Sí', 'a', 166),
(337, 'No', 'b', 166),
(338, 'Sí', 'a', 167),
(339, 'No', 'b', 167),
(340, 'Sí', 'a', 168),
(341, 'No', 'b', 168),
(342, 'Sí', 'a', 169),
(343, 'No', 'b', 169),
(344, 'Sí', 'a', 170),
(345, 'No', 'b', 170),
(346, 'Muy importante', 'a', 171),
(347, 'Algo importante', 'b', 171),
(348, 'No muy importante', 'c', 171),
(349, 'Sí', 'a', 172),
(350, 'No', 'b', 172),
(351, 'Sí', 'a', 173),
(352, 'No', 'b', 173),
(353, 'Sí', 'a', 174),
(354, 'No', 'b', 174),
(355, 'Muy grave', 'a', 175),
(356, 'Algo grave', 'b', 175),
(357, 'No es grave', 'c', 175),
(358, 'Sí', 'a', 176),
(359, 'No', 'b', 176),
(360, 'Sí', 'a', 177),
(361, 'No', 'b', 177),
(362, 'Sí', 'a', 178),
(363, 'No', 'b', 178),
(364, 'Sí', 'a', 179),
(365, 'No', 'b', 179),
(366, 'Sí', 'a', 180),
(367, 'No', 'b', 180),
(368, 'Sí', 'a', 181),
(369, 'No', 'b', 181),
(370, 'Sí', 'a', 182),
(371, 'No', 'b', 182),
(372, 'Sí', 'a', 183),
(373, 'No', 'b', 183),
(374, 'Sí', 'a', 184),
(375, 'No', 'b', 184),
(376, 'Sí', 'a', 185),
(377, 'No', 'b', 185),
(378, 'Sí', 'a', 186),
(379, 'No', 'b', 186),
(380, 'Sí', 'a', 187),
(381, 'No', 'b', 187),
(382, 'Sí', 'a', 188),
(383, 'No', 'b', 188),
(384, 'Sí', 'a', 189),
(385, 'No', 'b', 189),
(386, 'Sí', 'a', 190),
(387, 'No', 'b', 190),
(388, 'Sí', 'a', 191),
(389, 'No', 'b', 191),
(390, 'Sí', 'a', 192),
(391, 'No', 'b', 192),
(392, 'Sí', 'a', 193),
(393, 'No', 'b', 193),
(394, 'Sí', 'a', 194),
(395, 'No', 'b', 194),
(396, 'Sí', 'a', 195),
(397, 'No', 'b', 195),
(398, 'Sí', 'a', 196),
(399, 'No', 'b', 196),
(400, 'Sí', 'a', 197),
(401, 'No', 'b', 197),
(402, 'Sí', 'a', 198),
(403, 'No', 'b', 198),
(404, 'Sí', 'a', 199),
(405, 'No', 'b', 199),
(406, 'Sí', 'a', 200),
(407, 'No', 'b', 200),
(408, 'Sí', 'a', 201),
(409, 'No', 'b', 201),
(410, 'Sí', 'a', 202),
(411, 'No', 'b', 202),
(412, 'Sí', 'a', 203),
(413, 'No', 'b', 203),
(414, 'Sí', 'a', 204),
(415, 'No', 'b', 204),
(416, 'Sí', 'a', 205),
(417, 'No', 'b', 205),
(418, 'Sí', 'a', 206),
(419, 'No', 'b', 206),
(420, 'Sí', 'a', 207),
(421, 'No', 'b', 207),
(422, 'Sí', 'a', 208),
(423, 'No', 'b', 208),
(424, 'Sí', 'a', 209),
(425, 'No', 'b', 209),
(426, 'Sí', 'a', 210),
(427, 'No', 'b', 210),
(428, 'Sí', 'a', 211),
(429, 'No', 'b', 211),
(430, 'Sí', 'a', 212),
(431, 'No', 'b', 212),
(432, 'Sí', 'a', 213),
(433, 'No', 'b', 213),
(434, 'Sí', 'a', 214),
(435, 'No', 'b', 214),
(436, 'Sí', 'a', 215),
(437, 'No', 'b', 215),
(438, 'Sí', 'a', 216),
(439, 'No', 'b', 216),
(440, 'Sí', 'a', 217),
(441, 'No', 'b', 217),
(442, 'Sí', 'a', 218),
(443, 'No', 'b', 218),
(444, 'Sí', 'a', 219),
(445, 'No', 'b', 219),
(446, 'Sí', 'a', 220),
(447, 'No', 'b', 220),
(448, 'Sí', 'a', 221),
(449, 'No', 'b', 221),
(450, 'Sí', 'a', 222),
(451, 'No', 'b', 222),
(452, 'Sí', 'a', 223),
(453, 'No', 'b', 223),
(454, 'Sí', 'a', 224),
(455, 'No', 'b', 224),
(456, 'Sí', 'a', 225),
(457, 'No', 'b', 225),
(458, 'Sí', 'a', 226),
(459, 'No', 'b', 226),
(460, 'Sí', 'a', 227),
(461, 'No', 'b', 227),
(462, 'Sí', 'a', 228),
(463, 'No', 'b', 228),
(464, 'Sí', 'a', 229),
(465, 'No', 'b', 229),
(466, 'Sí', 'a', 230),
(467, 'No', 'b', 230),
(468, 'Sí', 'a', 231),
(469, 'No', 'b', 231),
(470, 'Sí', 'a', 232),
(471, 'No', 'b', 232),
(472, 'Sí', 'a', 233),
(473, 'No', 'b', 233),
(474, 'Sí', 'a', 234),
(475, 'No', 'b', 234),
(476, 'Sí', 'a', 235),
(477, 'No', 'b', 235),
(478, 'Sí', 'a', 236),
(479, 'No', 'b', 236),
(480, 'Sí', 'a', 237),
(481, 'No', 'b', 237),
(482, 'Sí', 'a', 238),
(483, 'No', 'b', 238),
(484, 'Sí', 'a', 239),
(485, 'No', 'b', 239),
(486, 'Sí', 'a', 240),
(487, 'No', 'b', 240),
(488, 'Sí', 'a', 241),
(489, 'No', 'b', 241),
(490, 'Sí', 'a', 242),
(491, 'No', 'b', 242),
(492, 'Sí', 'a', 243),
(493, 'No', 'b', 243),
(494, 'Sí', 'a', 244),
(495, 'No', 'b', 244),
(496, 'Sí', 'a', 245),
(497, 'No', 'b', 245),
(498, 'Sí', 'a', 246),
(499, 'No', 'b', 246),
(500, 'Sí', 'a', 247),
(501, 'No', 'b', 247),
(502, 'Sí', 'a', 248),
(503, 'No', 'b', 248),
(504, 'Sí', 'a', 249),
(505, 'No', 'b', 249),
(506, 'Sí', 'a', 250),
(507, 'No', 'b', 250),
(508, 'Lo ignoraría, ya que no me afecta.', 'a', 251),
(509, 'Sentiría que es algo malo, pero no intervendría.', 'b', 251),
(510, 'Le hablaría directamente sobre lo que está haciendo.', 'c', 251),
(511, 'Lo reportaría a mi superior.', 'd', 251),
(512, 'Me sentiría mal, pero trataría de arreglarlo lo más rápido posible.', 'a', 252),
(513, 'Probablemente lo ignoraría si no fuera tan grave.', 'b', 252),
(514, 'Lo asumiría, pero me costaría mucho admitirlo.', 'c', 252),
(515, 'Me disculparía con todos y trabajaría para evitarlo en el futuro.', 'd', 252),
(516, 'Lo haría, ya que mi jefe me lo pidió y es algo pequeño.', 'a', 253),
(517, 'Me sentiría incómodo, pero lo haría porque confío en mi jefe.', 'b', 253),
(518, 'Me sentiría muy mal y trataría de encontrar una manera de rechazar la solicitud de forma educada.', 'c', 253),
(519, 'No lo haría en absoluto, ya que sé que no es lo correcto.', 'd', 253),
(520, 'Las expectativas de los demás para \"ajustar\" los hechos.', 'a', 254),
(521, 'La presión de tener que cumplir con plazos y objetivos a veces poco realistas.', 'b', 254),
(522, 'La tentación de tomar \"atajos\" que pueden mejorar los resultados rápidamente.', 'c', 254),
(523, 'El miedo a las consecuencias que podrían ocurrir si soy completamente honesto.', 'd', 254),
(524, 'Le sugeriría que haga lo que le convenga, sin complicarse.', 'a', 255),
(525, 'Le hablaría sobre los pros y los contras de cada opción, dándole mi opinión sincera.', 'b', 255),
(526, 'Le diría que siempre siga lo que es justo, incluso si hay riesgos.', 'c', 255),
(527, 'Preferiría no involucrarme y decirle que lo maneje a su manera.', 'd', 255),
(528, 'No, no siempre siento que sea necesario.', 'a', 256),
(529, 'Sí, me gusta devolver el favor, aunque no siempre sé cómo.', 'b', 256),
(530, 'Solo lo haría si realmente la otra persona me ayudó de una manera importante.', 'c', 256),
(531, 'Siempre siento que debo devolverlo para mantener la relación balanceada.', 'd', 256),
(532, 'No intervendría, ya que no es asunto mío.', 'a', 257),
(533, 'Me sentiría incómodo, pero no diría nada.', 'b', 257),
(534, 'Le hablaría en privado para expresarle mi preocupación.', 'c', 257),
(535, 'Sentiría que es mi responsabilidad ayudarlo a corregir su error.', 'd', 257),
(536, 'No haría nada, ya que no quiero involucrarme en asuntos personales.', 'a', 258),
(537, 'Le preguntaría si necesita ayuda o apoyo en alguna forma.', 'b', 258),
(538, 'Le sugeriría hablar con recursos humanos o su supervisor.', 'c', 258),
(539, 'Intentaría ayudarle directamente, incluso si eso significa tomar un poco más de carga de trabajo.', 'd', 258),
(540, '¿Cómo me afectará esto en el futuro?', 'a', 259),
(541, '¿Es esta la mejor opción para mí en este momento?', 'b', 259),
(542, '¿Qué es lo correcto en esta situación, sin importar las consecuencias?', 'c', 259),
(543, '¿Cómo se sentirán los demás sobre mi decisión?', 'd', 259),
(544, 'Lo tomaría, ya que los resultados rápidos pueden ser necesarios.', 'a', 260),
(545, 'Me sentiría tentado, pero probablemente buscaría una alternativa más ética.', 'b', 260),
(546, 'No lo tomaría en serio, ya que no es lo que yo considero correcto.', 'c', 260),
(547, 'Lo rechazaría de inmediato, ya que prefiero hacer las cosas bien desde el principio.', 'd', 260),
(548, 'No es tan importante, a veces es mejor no decir la verdad.', 'a', 261),
(549, 'Creo que es importante, pero a veces es complicado.', 'b', 261),
(550, 'Es muy importante, pero depende de la situación.', 'c', 261),
(551, 'Siempre trato de ser completamente honesto, no importa lo que pase.', 'd', 261),
(552, 'Trataría de evitar responder, ya que me sentiría incómodo.', 'a', 262),
(553, 'Respondería lo mejor que pueda, pero sin entrar en demasiados detalles.', 'b', 262),
(554, 'Sería completamente honesto, aunque me sintiera un poco incómodo.', 'c', 262),
(555, 'Me sentiría muy cómodo respondiendo, ya que siempre prefiero ser honesto.', 'd', 262),
(556, 'No me involucraría porque no me quiero meter en problemas.', 'a', 263),
(557, 'Hablaría con la persona que hace la acusación para tratar de aclararlo.', 'b', 263),
(558, 'Apoyaría al compañero y ayudaría a limpiar su nombre.', 'c', 263),
(559, 'Informaría a los superiores sobre lo que he visto.', 'd', 263),
(560, 'Probablemente sí, ya que no causaría mucho daño.', 'a', 264),
(561, 'No, ya que no me sentiría bien haciéndolo.', 'b', 264),
(562, 'Intentaría buscar una forma de conseguir lo que quiero de manera honesta.', 'c', 264),
(563, 'Definitivamente no, ya que la honestidad siempre debe ser mi prioridad.', 'd', 264),
(564, 'Intentaría defenderme de la mejor manera posible.', 'a', 265),
(565, 'Trataría de explicarlo de forma calmada y razonable.', 'b', 265),
(566, 'Intentaría mostrar a todos que mis intenciones eran buenas, aunque me equivoqué.', 'c', 265),
(567, 'Sería completamente honesto sobre lo que ocurrió, incluso si eso me afecta negativamente.', 'd', 265);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_respuestas_usuario`
--

DROP TABLE IF EXISTS `psico_alobri_respuestas_usuario`;
CREATE TABLE IF NOT EXISTS `psico_alobri_respuestas_usuario` (
  `user_id` bigint UNSIGNED NOT NULL,
  `pregunta_id` int NOT NULL,
  `respuesta_id` int NOT NULL,
  `ip_usuario` varchar(40) NOT NULL,
  `token_id` bigint UNSIGNED DEFAULT NULL,
  KEY `pregunta_id` (`pregunta_id`),
  KEY `respuesta_id` (`respuesta_id`),
  KEY `user_id` (`user_id`),
  KEY `token_id` (`token_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_respuestas_usuario`
--

INSERT INTO `psico_alobri_respuestas_usuario` (`user_id`, `pregunta_id`, `respuesta_id`, `ip_usuario`, `token_id`) VALUES
(12, 32, 68, '::1', 2),
(12, 6, 14, '::1', 2),
(12, 11, 25, '::1', 2),
(12, 10, 22, '::1', 2),
(12, 19, 42, '::1', 2),
(12, 35, 74, '::1', 2),
(12, 17, 38, '::1', 2),
(12, 16, 37, '::1', 2),
(12, 8, 18, '::1', 2),
(12, 18, 41, '::1', 2),
(12, 1, 2, '::1', 2),
(12, 29, 62, '::1', 2),
(12, 14, 31, '::1', 2),
(12, 33, 71, '::1', 2),
(12, 26, 56, '::1', 2),
(12, 23, 51, '::1', 2),
(12, 25, 55, '::1', 2),
(12, 27, 59, '::1', 2),
(12, 4, 10, '::1', 2),
(12, 21, 46, '::1', 2),
(12, 13, 30, '::1', 2),
(12, 20, 44, '::1', 2),
(12, 59, 122, '::1', 2),
(12, 99, 203, '::1', 2),
(12, 130, 264, '::1', 2),
(12, 113, 230, '::1', 2),
(12, 154, 312, '::1', 2),
(12, 148, 301, '::1', 2),
(12, 183, 372, '::1', 2),
(17, 12, 27, '::1', NULL),
(17, 7, 16, '::1', NULL),
(17, 17, 38, '::1', NULL),
(17, 32, 68, '::1', NULL),
(17, 25, 54, '::1', NULL),
(17, 2, 4, '::1', NULL),
(17, 31, 66, '::1', NULL),
(17, 33, 70, '::1', NULL),
(17, 14, 31, '::1', NULL),
(17, 30, 64, '::1', NULL),
(17, 21, 46, '::1', NULL),
(17, 18, 40, '::1', NULL),
(17, 35, 74, '::1', NULL),
(17, 1, 1, '::1', NULL),
(17, 10, 22, '::1', NULL),
(17, 27, 58, '::1', NULL),
(17, 4, 8, '::1', NULL),
(17, 8, 18, '::1', NULL),
(17, 24, 52, '::1', NULL),
(17, 22, 48, '::1', NULL),
(17, 15, 34, '::1', NULL),
(17, 29, 62, '::1', NULL),
(17, 3, 6, '::1', NULL),
(17, 23, 50, '::1', NULL),
(17, 9, 20, '::1', NULL),
(17, 5, 11, '::1', NULL),
(17, 26, 56, '::1', NULL),
(17, 20, 44, '::1', NULL),
(17, 13, 29, '::1', NULL),
(17, 28, 60, '::1', NULL),
(17, 34, 72, '::1', NULL),
(17, 6, 13, '::1', NULL),
(17, 16, 36, '::1', NULL),
(17, 11, 25, '::1', NULL),
(17, 19, 42, '::1', NULL),
(17, 12, 27, '::1', NULL),
(17, 7, 16, '::1', NULL),
(17, 17, 38, '::1', NULL),
(17, 32, 68, '::1', NULL),
(17, 25, 54, '::1', NULL),
(17, 2, 4, '::1', NULL),
(17, 31, 66, '::1', NULL),
(17, 33, 70, '::1', NULL),
(17, 14, 31, '::1', NULL),
(17, 30, 64, '::1', NULL),
(17, 21, 46, '::1', NULL),
(17, 18, 40, '::1', NULL),
(17, 35, 74, '::1', NULL),
(17, 1, 1, '::1', NULL),
(17, 10, 22, '::1', NULL),
(17, 27, 58, '::1', NULL),
(17, 4, 8, '::1', NULL),
(17, 8, 18, '::1', NULL),
(17, 24, 52, '::1', NULL),
(17, 22, 48, '::1', NULL),
(17, 15, 34, '::1', NULL),
(17, 29, 62, '::1', NULL),
(17, 3, 6, '::1', NULL),
(17, 23, 50, '::1', NULL),
(17, 9, 20, '::1', NULL),
(17, 5, 11, '::1', NULL),
(17, 26, 56, '::1', NULL),
(17, 20, 44, '::1', NULL),
(17, 13, 29, '::1', NULL),
(17, 28, 60, '::1', NULL),
(17, 34, 72, '::1', NULL),
(17, 6, 13, '::1', NULL),
(17, 16, 36, '::1', NULL),
(17, 11, 25, '::1', NULL),
(17, 19, 42, '::1', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_secciones`
--

DROP TABLE IF EXISTS `psico_alobri_secciones`;
CREATE TABLE IF NOT EXISTS `psico_alobri_secciones` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `bloque` tinyint NOT NULL,
  `categoria_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `time_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_secciones`
--

INSERT INTO `psico_alobri_secciones` (`id`, `titulo`, `bloque`, `categoria_id`, `created_at`, `updated_at`, `time_at`) VALUES
(1, 'Honestidad en el Trabajo', 1, 1, '2025-03-19 16:41:25', '2025-03-19 16:41:25', '2025-04-04 05:00:30'),
(2, 'Ética Profesional y Responsabilidad', 2, 1, '2025-03-25 14:15:21', '2025-03-25 14:15:21', '0000-00-00 00:00:00'),
(3, 'Habilidades de Resolución de Problemas y Toma de de decisiones', 3, 1, '2025-03-20 14:55:26', '2025-03-20 14:55:26', '2025-03-20 05:00:01'),
(4, 'Comportamientos pasados', 1, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(5, 'Actitudes hacia el Comportamiento Deshonesto', 1, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(6, 'Reacciones ante Tentaciones', 1, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(7, 'Opiniones sobre Honestidad', 1, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(8, 'Actitudes hacia la Deshonestidad', 2, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(9, 'Justificaciones para la Deshonestidad', 2, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(10, 'Reacciones ante Situaciones Deshonestas', 2, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(11, 'Valoración de la Honestidad en Situaciones de Conf', 2, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(12, 'Percepción de la Honestidad', 2, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(13, 'Evaluación de Tolerancia a la Deshonestidad', 3, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(14, 'Conflicto de Intereses', 3, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(15, 'Responsabilidad y Decisiones en el Trabajo', 3, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(16, 'Reflexión sobre la Honestidad', 3, 2, '2025-04-08 14:01:03', '2025-04-08 14:01:03', '0000-00-00 00:00:00'),
(17, 'Reflexiones sobre la Honestidad en el Trabajo', 4, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01'),
(18, 'Actitudes hacia la Honestidad  en la Vida Cotidian', 4, 2, '2025-03-19 16:50:36', '2025-03-19 16:50:36', '2025-03-21 05:00:01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_tokens_evaluaciones`
--

DROP TABLE IF EXISTS `psico_alobri_tokens_evaluaciones`;
CREATE TABLE IF NOT EXISTS `psico_alobri_tokens_evaluaciones` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_tokens_evaluaciones`
--

INSERT INTO `psico_alobri_tokens_evaluaciones` (`id`, `token`, `user_id`, `created_at`) VALUES
(2, '$2y$12$oFJmWOAENicykcHJzbWdyuhuuIfguMLvWs.oxtEC.dC9Jv68dK2Ny', 12, '2025-04-08 12:17:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_users_info`
--

DROP TABLE IF EXISTS `psico_alobri_users_info`;
CREATE TABLE IF NOT EXISTS `psico_alobri_users_info` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `genero` varchar(50) DEFAULT NULL,
  `codigo_postal` varchar(20) DEFAULT NULL,
  `celular` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_users_info`
--

INSERT INTO `psico_alobri_users_info` (`id`, `user_id`, `fecha_nacimiento`, `genero`, `codigo_postal`, `celular`, `created_at`) VALUES
(42, 36, '1955-04-29', 'masculino', '12345', '3178905500', '2025-04-11 14:50:50'),
(43, 37, '1958-05-30', 'femenino', 'aaaaaa', '3333333333', '2025-04-11 16:06:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_usuarios_categorias`
--

DROP TABLE IF EXISTS `psico_alobri_usuarios_categorias`;
CREATE TABLE IF NOT EXISTS `psico_alobri_usuarios_categorias` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint UNSIGNED NOT NULL,
  `categorias_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `categorias_id` (`categorias_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `psico_alobri_usuarios_categorias`
--

INSERT INTO `psico_alobri_usuarios_categorias` (`id`, `user_id`, `categorias_id`) VALUES
(11, 36, 1),
(12, 37, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `psico_alobri_usuarios_tokens`
--

DROP TABLE IF EXISTS `psico_alobri_usuarios_tokens`;
CREATE TABLE IF NOT EXISTS `psico_alobri_usuarios_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` text NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `is_psico_alobri` tinyint NOT NULL DEFAULT '0',
  `is_super_admin` tinyint(1) NOT NULL DEFAULT '0',
  `is_admin` int NOT NULL DEFAULT '0',
  `company_id` int DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `is_psico_alobri`, `is_super_admin`, `is_admin`, `company_id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 0, 1, 0, NULL, 'Admin', 'admin@admin.com', NULL, '$2y$12$dae1aSsIBMHC0SQIiTy4Su2wn1MPlAwdJ9MegxAJnCI8kX8Sy1Ike', NULL, '2025-04-08 23:59:42', '2025-04-08 23:59:42'),
(29, 0, 0, 1, 0, 'Usuario_Company\r\n', 'usuario_company@admin.com', NULL, '$2y$12$dae1aSsIBMHC0SQIiTy4Su2wn1MPlAwdJ9MegxAJnCI8kX8Sy1Ike', NULL, '2025-04-08 23:59:42', '2025-04-08 23:59:42'),
(36, 0, 0, 0, 1, 'Candidato Prueba', 'p@gmail.com', NULL, '$2y$12$N3LdTMigUlnMH6P44NkQvOys4pftfsjAUXxfQud.yhKifW7A6OMrq', NULL, '2025-04-11 19:50:50', '2025-04-11 19:51:58'),
(37, 0, 0, 0, 2, 'b b', 'bbalexa@gmail.com', NULL, '$2y$12$8iIjtTpfr//QNBqa7GGSHOENSZEr1LTVfK.PpFIobxtq8GIP7TC.C', NULL, '2025-04-11 21:06:07', '2025-04-11 21:06:07');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `psico_alobri_preguntas`
--
ALTER TABLE `psico_alobri_preguntas`
  ADD CONSTRAINT `psico_alobri_preguntas_ibfk_1` FOREIGN KEY (`seccion_id`) REFERENCES `psico_alobri_secciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `psico_alobri_pregunta_y_respuesta_correcta`
--
ALTER TABLE `psico_alobri_pregunta_y_respuesta_correcta`
  ADD CONSTRAINT `psico_alobri_pregunta_y_respuesta_correcta_ibfk_1` FOREIGN KEY (`respuesta_id`) REFERENCES `psico_alobri_respuestas` (`respuesta_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `psico_alobri_pregunta_y_respuesta_correcta_ibfk_2` FOREIGN KEY (`pregunta_id`) REFERENCES `psico_alobri_preguntas` (`pregunta_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `psico_alobri_respuestas`
--
ALTER TABLE `psico_alobri_respuestas`
  ADD CONSTRAINT `psico_alobri_respuestas_ibfk_1` FOREIGN KEY (`pregunta_id`) REFERENCES `psico_alobri_preguntas` (`pregunta_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
