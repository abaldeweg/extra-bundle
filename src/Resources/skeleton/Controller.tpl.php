<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use App\Entity\<?= $entity; ?>;
use App\Form\<?= $entity; ?>Type;
use Baldeweg\Bundle\ApiBundle\AbstractApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/<?= $name_lowercase; ?>")
 */
class <?= $class_name ?> extends AbstractApiController
{
    private $fields = [];

    /**
     * @Route("/", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function index(): JsonResponse
    {
        return $this->setResponse()->collection(
            $this->fields,
            $this->getDoctrine()->getRepository(<?= $entity; ?>::class)->findAll()
        );
    }

    /**
     * @Route("/{<?= $name_lowercase; ?>}", methods={"GET"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function show(<?= $entity; ?> $<?= $name_lowercase; ?>): JsonResponse
    {
        return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
    }

    /**
     * @Route("/new", methods={"POST"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function new(Request $request): JsonResponse
    {
        $<?= $name_lowercase; ?> = new <?= $entity; ?>();
        $form = $this->createForm(<?= $entity; ?>Type::class, $<?= $name_lowercase; ?>);

        $form->submit(
            $this->submitForm($request)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($<?= $name_lowercase; ?>);
            $em->flush();

            return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
        }

        return $this->setResponse()->invalid();
    }

    /**
     * @Route("/{<?= $name_lowercase; ?>}", methods={"PUT"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function edit(Request $request, <?= $entity; ?> $<?= $name_lowercase; ?>): JsonResponse
    {
        $form = $this->createForm(<?= $entity; ?>Type::class, $<?= $name_lowercase; ?>);

        $form->submit(
            $this->submitForm($request)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
        }

        return $this->setResponse()->invalid();
    }

    /**
     * @Route("/{<?= $name_lowercase; ?>}", methods={"DELETE"})
     * @Security("is_granted('ROLE_USER')")
     */
    public function delete(<?= $entity; ?> $<?= $name_lowercase; ?>): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($<?= $name_lowercase; ?>);
        $em->flush();

        return $this->setResponse()->deleted();
    }
}
