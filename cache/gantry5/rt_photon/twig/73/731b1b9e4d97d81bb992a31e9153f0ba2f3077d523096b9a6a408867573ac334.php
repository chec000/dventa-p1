<?php

/* @particles/newsticker.html.twig */
class __TwigTemplate_9b7896a117f25fa864d3234d41c3aa07cd7398ca16e537f08d9a769a84130171 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/newsticker.html.twig", 1);
        $this->blocks = array(
            'javascript' => array($this, 'block_javascript'),
            'particle' => array($this, 'block_particle'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_javascript($context, array $blocks = array())
    {
        // line 4
        echo "<script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/newsticker.js"), "html", null, true);
        echo "\"></script>
";
    }

    // line 7
    public function block_particle($context, array $blocks = array())
    {
        // line 8
        echo "<div class=\"";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "class", array()));
        echo "\">
  \t";
        // line 9
        if ($this->getAttribute(($context["particle"] ?? null), "title", array())) {
            echo "<h2 class=\"g-title\">";
            echo $this->getAttribute(($context["particle"] ?? null), "title", array());
            echo "</h2>";
        }
        // line 10
        echo "\t<div class=\"g-newsticker\">
\t\t";
        // line 11
        if ($this->getAttribute(($context["particle"] ?? null), "label", array())) {
            echo " <div class=\"g-newsticker-label\">";
            echo $this->getAttribute(($context["particle"] ?? null), "label", array());
            echo "</div> ";
        }
        // line 12
        echo "
\t\t<div class=\"g-newsticker-container g-newsticker-";
        // line 13
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "\">
\t\t\t<div class=\"g-newsticker-innerwrap\">
\t\t    ";
        // line 15
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["particle"] ?? null), "items", array()));
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 16
            echo "\t\t\t\t<div class=\"g-newsticker-content\">
\t\t\t\t\t<span class=\"g-newsticker-content-text\">";
            // line 17
            echo $this->getAttribute($context["item"], "content", array());
            echo "</span>

\t\t\t\t\t";
            // line 19
            if ($this->getAttribute($context["item"], "readmoretext", array())) {
                // line 20
                echo "\t\t\t\t\t\t<span class=\"g-newsticker-elipsis\">...</span>
\t\t\t\t\t\t<span class=\"g-newsticker-readmore\"> <a target=\"";
                // line 21
                echo twig_escape_filter($this->env, (($this->getAttribute($context["item"], "readmoretarget", array(), "any", true, true)) ? (_twig_default_filter($this->getAttribute($context["item"], "readmoretarget", array()), "_self")) : ("_self")));
                echo "\" href=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "readmorelink", array()));
                echo "\" title=\"";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "readmoretext", array()));
                echo "\">";
                echo twig_escape_filter($this->env, $this->getAttribute($context["item"], "readmoretext", array()));
                echo "</a> </span>
\t\t\t\t\t";
            }
            // line 23
            echo "\t\t\t\t</div>
\t\t    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 25
        echo "\t\t    </div>
\t\t\t<div class=\"g-newsticker-controller\">
\t\t\t\t<div class=\"g-next\"><span class=\"g-next-icon\"></span></div>
\t\t\t\t<div class=\"g-prev\"><span class=\"g-prev-icon\"></span></div>
\t\t\t</div>
\t    </div>
    </div>
    <div class=\"clearfix\"></div>
</div>
";
    }

    // line 36
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 37
        echo "\t";
        $this->getAttribute(($context["gantry"] ?? null), "load", array(0 => "jquery"), "method");
        // line 38
        echo "\t<script type=\"text/javascript\">
\tjQuery(document).ready(function(){
\t\tjQuery('.g-newsticker-";
        // line 40
        echo twig_escape_filter($this->env, ($context["id"] ?? null), "html", null, true);
        echo "').easyTicker({
\t\t\tdirection: '";
        // line 41
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "Direction", array()), "html", null, true);
        echo "',
\t\t\tspeed: '";
        // line 42
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "speed", array()), "html", null, true);
        echo "',
\t\t\tinterval: ";
        // line 43
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "Interval", array()), "html", null, true);
        echo ",
\t\t\theight: 'auto',
\t\t\tvisible: 1,
\t\t\tmousePause: 1,
\t\t\tcontrols: {
\t\t\t\tup: '.g-next',
\t\t\t\tdown: '.g-prev'
\t\t\t}
\t\t});
\t});
\t</script>
";
    }

    public function getTemplateName()
    {
        return "@particles/newsticker.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 43,  137 => 42,  133 => 41,  129 => 40,  125 => 38,  122 => 37,  119 => 36,  106 => 25,  99 => 23,  88 => 21,  85 => 20,  83 => 19,  78 => 17,  75 => 16,  71 => 15,  66 => 13,  63 => 12,  57 => 11,  54 => 10,  48 => 9,  43 => 8,  40 => 7,  33 => 4,  30 => 3,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/newsticker.html.twig", "/home1/adboxadm/public_html/incentiva/templates/rt_photon/custom/particles/newsticker.html.twig");
    }
}
