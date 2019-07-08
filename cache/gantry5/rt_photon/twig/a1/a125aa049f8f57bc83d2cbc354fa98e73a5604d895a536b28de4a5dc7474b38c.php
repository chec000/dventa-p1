<?php

/* @nucleus/content/missing.html.twig */
class __TwigTemplate_f11a4e4770b01afe73d75d2743ee88465934feabb163c003a252548a062723a4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"alert alert-error\"><strong>Missing content:</strong> '";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["segment"] ?? null), "subtype", array()), "html", null, true);
        echo "' ";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["segment"] ?? null), "type", array()), "html", null, true);
        echo " cannot be found.</div>
";
    }

    public function getTemplateName()
    {
        return "@nucleus/content/missing.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@nucleus/content/missing.html.twig", "C:\\xampp\\htdocs\\dventa\\media\\gantry5\\engines\\nucleus\\templates\\content\\missing.html.twig");
    }
}
