<?php

/* @particles/imagegrid.html.twig */
class __TwigTemplate_c8e57b51a3a187a8f1eb45b9ccae880ed83a5a4545b0a931dd26b59861666f31 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/imagegrid.html.twig", 1);
        $this->blocks = array(
            'particle' => array($this, 'block_particle'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 3
        $this->getAttribute(($context["gantry"] ?? null), "load", array(0 => "lightcase.init"), "method");
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_particle($context, array $blocks = array())
    {
        // line 6
        echo "
\t";
        // line 7
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        // line 8
        echo "
\t<div class=\"g-imagegrid ";
        // line 9
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">

\t\t";
        // line 11
        if ($this->getAttribute(($context["particle"] ?? null), "desc", array())) {
            echo "<div class=\"g-imagegrid-desc\">";
            echo $this->getAttribute(($context["particle"] ?? null), "desc", array());
            echo "</div>";
        }
        // line 12
        echo "
\t\t<div class=\"g-imagegrid-wrapper ";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "cols", array()));
        echo "\">
\t\t\t";
        // line 14
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "imagegriditems", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["imagegriditem"]) {
            // line 15
            echo "\t\t\t    <div class=\"g-imagegrid-item\">
\t\t\t\t\t\t\t<a href=\"";
            // line 16
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc($this->getAttribute($context["imagegriditem"], "url", array())), "html", null, true);
            echo "\"> <img src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc($this->getAttribute($context["imagegriditem"], "image", array())));
            echo "\" title=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["imagegriditem"], "caption", array()));
            echo "\" alt=\"";
            echo twig_escape_filter($this->env, $this->getAttribute($context["imagegriditem"], "caption", array()));
            echo "\"> </a>
\t\t\t\t\t</div>
\t\t\t";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['imagegriditem'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 19
        echo "\t\t</div>

\t</div>

";
    }

    public function getTemplateName()
    {
        return "@particles/imagegrid.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 19,  71 => 16,  68 => 15,  64 => 14,  60 => 13,  57 => 12,  51 => 11,  46 => 9,  43 => 8,  37 => 7,  34 => 6,  31 => 5,  27 => 1,  25 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/imagegrid.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\custom\\particles\\imagegrid.html.twig");
    }
}
