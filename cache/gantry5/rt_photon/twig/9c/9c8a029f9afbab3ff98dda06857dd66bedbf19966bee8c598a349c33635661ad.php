<?php

/* @particles/bg-video.html.twig */
class __TwigTemplate_0ce3e61082127c1f1a315e0d2a60a0cfda9bb23329be546b91c5f7434fca8267 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        $this->parent = $this->loadTemplate("@nucleus/partials/particle.html.twig", "@particles/bg-video.html.twig", 1);
        $this->blocks = array(
            'stylesheets' => array($this, 'block_stylesheets'),
            'javascript' => array($this, 'block_javascript'),
            'javascript_footer' => array($this, 'block_javascript_footer'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "@nucleus/partials/particle.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 15
        if ($this->getAttribute(($context["particle"] ?? null), "controls", array())) {
            // line 16
            $context["viewControls"] = "true";
        } else {
            // line 18
            $context["viewControls"] = "false";
        }
        // line 21
        if ($this->getAttribute(($context["particle"] ?? null), "loop", array())) {
            // line 22
            $context["Loop"] = "true";
        } else {
            // line 24
            $context["Loop"] = "false";
        }
        // line 1
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 4
    public function block_stylesheets($context, array $blocks = array())
    {
        // line 5
        echo "  <link rel=\"stylesheet\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://css/jquery.mb.YTPlayer.min.css"), "html", null, true);
        echo "\" media=\"all\" type=\"text/css\" />
";
    }

    // line 8
    public function block_javascript($context, array $blocks = array())
    {
        // line 9
        echo "  ";
        if ($this->getAttribute(($context["particle"] ?? null), "jquery", array())) {
            // line 10
            echo "    <script src=\"";
            echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("http://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"), "html", null, true);
            echo "\"></script>
  ";
        }
        // line 12
        echo "  <script src=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('Gantry\Component\Twig\TwigExtension')->urlFunc("gantry-theme://js/jquery.mb.YTPlayer.js"), "html", null, true);
        echo "\"></script>
";
    }

    // line 27
    public function block_javascript_footer($context, array $blocks = array())
    {
        // line 28
        echo "<script>
  \$(\"body\").append('<div id=\"bgVideo\" class=\"player\" data-property=\"{videoURL:\\'";
        // line 29
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "urlVideo", array()), "html", null, true);
        echo "\\',containment:\\'body\\',autoPlay:true,";
        if ($this->getAttribute(($context["particle"] ?? null), "mute", array())) {
            echo " mute:true,";
        }
        echo " startAt:";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "startAt", array()), "html", null, true);
        echo ", opacity:";
        echo twig_escape_filter($this->env, $this->getAttribute(($context["particle"] ?? null), "opacity", array()), "html", null, true);
        echo ", showControls:";
        echo twig_escape_filter($this->env, ($context["viewControls"] ?? null), "html", null, true);
        echo ", loop:";
        echo twig_escape_filter($this->env, ($context["Loop"] ?? null), "html", null, true);
        echo ",  }\"></div>' );
  \$(function(){
    \$(\"#bgVideo\").mb_YTPlayer();
  });
</script>
";
    }

    public function getTemplateName()
    {
        return "@particles/bg-video.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 29,  79 => 28,  76 => 27,  69 => 12,  63 => 10,  60 => 9,  57 => 8,  50 => 5,  47 => 4,  43 => 1,  40 => 24,  37 => 22,  35 => 21,  32 => 18,  29 => 16,  27 => 15,  11 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "@particles/bg-video.html.twig", "C:\\xampp\\htdocs\\dventa\\templates\\rt_photon\\custom\\particles\\bg-video.html.twig");
    }
}
